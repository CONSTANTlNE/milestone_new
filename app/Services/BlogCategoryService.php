<?php

namespace App\Services;

use App\Contracts\BlogCategoryInterface;
use App\Http\Requests\BlogCategory\BlogCategoryChangeStatusRequest;
use App\Http\Requests\BlogCategory\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategory\BlogCategoryDestroyRequest;
use App\Http\Requests\BlogCategory\BlogCategoryMassDestroyRequest;
use App\Http\Requests\BlogCategory\BlogCategoryMassRemoveRequest;
use App\Http\Requests\BlogCategory\BlogCategoryRemoveRequest;
use App\Http\Requests\BlogCategory\BlogCategoryRestoreRequest;
use App\Http\Requests\BlogCategory\BlogCategoryTrashRequest;
use App\Http\Requests\BlogCategory\BlogCategoryUpdateRequest;
use App\Http\Resources\BlogCategory\BlogCategoryResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\BlogCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\BlogCategory\BlogCategoryIndexRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlogCategoryService implements BlogCategoryInterface
{
    use MenuTrait, ImageUploadTrait, MultiTranslatableTrait;

    private const CACHE_TTL = 3600; // 1 hour
    private const CACHE_PREFIX = 'blog_categories';

    public function index(BlogCategoryIndexRequest $request): LengthAwarePaginator
    {
        return BlogCategory::select(['id', 'title', 'src', 'created_at', 'status'])
            ->filter($request)
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function getSeoFirst(BlogCategory $blogCategory)
    {
            return $blogCategory->seo()->first();
    }

    public function changeStatus(BlogCategoryChangeStatusRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $blogCategory = BlogCategory::findOrFail($data['id']);
            $blogCategory->update(['status' => $data['status']]);
            $blogCategory->setActive($data['status']);

            DB::commit();

            return response()->json([
                'message' => __('strings.Status changed successfully'),
                'alert-type' => 'success',
                'blogCategory' => BlogCategoryResource::make($blogCategory)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to change blog category status: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    public function store(BlogCategoryCreateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $blogCategory = new BlogCategory();
            $blogCategory->setMultiTranslations($data);
            $blogCategory->status = $data['status'];
            $blogCategory->created_at = $data['published_at'] ?? now();

            $blogCategory->save();

            $blogCategory->setSeoTranslations($data);
            $this->processAndSaveImages($data, $blogCategory, true);
            $blogCategory->fresh();

            DB::commit();

            return response()->json([
                'blogCategory' => BlogCategoryResource::make($blogCategory),
                'message' => __('strings.Added Successfully')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create blog category: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    public function show(BlogCategory $blogCategory): JsonResponse|BlogCategory
    {
         return $blogCategory->load(['images', 'seo']);
    }

    public function edit(BlogCategory $blogCategory): BlogCategory
    {
        return $blogCategory->load(['images', 'seo']);
    }

    public function update(BlogCategoryUpdateRequest $request, BlogCategory $blogCategory): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $blogCategory->setMultiTranslations($data);
            $blogCategory->status = $data['status'];
            $blogCategory->created_at = $data['published_at'] ?? now();

            $blogCategory->save();

            // Set Menu translations if available
            $blogCategory->setMenuTranslations(
                $blogCategory->getTranslations('title'),
                $blogCategory->getTranslations('slug')
            );

            $blogCategory->setActive($data['status']);

            // Set SEO translations if available
            $blogCategory->setSeoTranslations($data);
            $this->processAndSaveImages($data, $blogCategory, true);
            $blogCategory->fresh();

            DB::commit();

            return response()->json([
                'blogCategory' => BlogCategoryResource::make($blogCategory),
                'message' => __('strings.Updated Successfully')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to update blog category: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    public function destroy(BlogCategoryDestroyRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $blogCategory = BlogCategory::findOrFail($request->id);

            // Detach relationships before deletion
            $blogCategory->setActive(false);

            $blogCategory->delete();

            DB::commit();

            return response()->json([
                'message' => __('strings.Deleted Successfully'),
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to delete blog category: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    public function massDestroy(BlogCategoryMassDestroyRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $categoryIds = $request->ids;

            $blogCategories = BlogCategory::whereIn('id', $categoryIds)->get();

            foreach ($blogCategories as $blogCategory) {
                $blogCategory->setActive(false);
            }

            BlogCategory::whereIn('id', $categoryIds)->delete();

            DB::commit();

            return response()->json([
                'message' => __('strings.massDestroy Successfully'),
                'deleted_count' => count($categoryIds)
            ], 204);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to mass delete blog categories: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    // Archive Function Method
    public function trash(BlogCategoryTrashRequest $request): LengthAwarePaginator
    {
        return BlogCategory::select(['id', 'title', 'created_at', 'deleted_at'])
            ->withTrashed()
            ->filterTrash($request)
            ->orderBy('deleted_at', 'desc')
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function restore(BlogCategoryRestoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $blogCategory = BlogCategory::where('id', $request->id)->withTrashed()->firstOrFail();
            $blogCategory->restore();
            $blogCategory->setActive(false);
            $blogCategory->fresh();

            DB::commit();

            return response()->json([
                'message' => __('strings.Restored Successfully from Archive'),
                'alert-type' => 'success',
                'blogCategory' => BlogCategoryResource::make($blogCategory)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to restore blog category: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    public function remove(BlogCategoryRemoveRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $blogCategory = BlogCategory::where('id', $request->id)->withTrashed()->firstOrFail();

            // Force delete all relationships
            $blogCategory->seo()->forceDelete();
            $blogCategory->images()->detach();
            $blogCategory->blogs()->detach();
            $blogCategory->setForceDelete(true);
            $blogCategory->forceDelete();

            DB::commit();

            return response()->json([
                'message' => __('strings.Deleted Successfully from Archive'),
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to permanently delete blog category: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    public function massRemove(BlogCategoryMassRemoveRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $categoryIds = $request->ids;

            $blogCategories = BlogCategory::withTrashed()->whereIn('id', $categoryIds)->get();

            foreach ($blogCategories as $blogCategory) {
                $blogCategory->seo()->forceDelete();
                $blogCategory->setForceDelete(true);
                $blogCategory->images()->detach();
                $blogCategory->blogs()->detach();
            }

            BlogCategory::whereIn('id', $categoryIds)->withTrashed()->forceDelete();

            DB::commit();

            return response()->json([
                'message' => __('strings.Mass Deleted Successfully from Archive'),
                'deleted_count' => count($categoryIds)
            ], 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to mass permanently delete blog categories: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }
}
