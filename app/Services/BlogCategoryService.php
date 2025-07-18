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

class BlogCategoryService implements BlogCategoryInterface
{
    use MenuTrait, ImageUploadTrait, MultiTranslatableTrait;

    public function index(BlogCategoryIndexRequest $request): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        return BlogCategory::query()
            ->when($request->filled('search'), function ($query) use ($request, $locale) {
                $search = $request->search;
                $query->where(function ($q) use ($search, $locale) {
                    $q->whereRaw('CAST(id AS TEXT) ILIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw("title->>? ILIKE ?", [$locale, '%' . $search . '%']);
                });
            })
            ->when($request->filled('status') && $request->status !== 'all', function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy(
                $request->input('sort_column', 'id'),
                $request->input('sort_direction', 'desc')
            )
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function getSeoFirst(BlogCategory $blogCategory)
    {
        return $blogCategory->seo()->first();
    }

    public function changeStatus(BlogCategoryChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('blogCategories');

        $blogCategory = BlogCategory::find($data['id']);

        if (!$blogCategory) {
            return response()->json([
                'message' => 'BlogCategory not found',
                'alert-type' => 'error'
            ], 404);
        }

        $blogCategory->update(['status' => $data['status']]);
        $blogCategory->setActive($data['status']);

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(BlogCategoryCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('blogCategories');

        $blogCategory = new BlogCategory();
        $blogCategory->setMultiTranslations($data);
        $blogCategory->status = $data['status'];
        $blogCategory->created_at = $data['published_at'] ?? now();
        $blogCategory->save();

        $blogCategory->setSeoTranslations($data);
        $this->processAndSaveImages($data, $blogCategory, true);
        $blogCategory->fresh();

        return response()->json([
            'blogCategory' => BlogCategoryResource::make($blogCategory),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(BlogCategory $blogCategory): JsonResponse|BlogCategory
    {
        return $blogCategory;
    }

    public function edit(BlogCategory $blogCategory): BlogCategory
    {
        return $blogCategory;
    }

    public function update(BlogCategoryUpdateRequest $request, BlogCategory $blogCategory): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('blogCategories');
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

        return response()->json([
            'blogCategory' => BlogCategoryResource::make($blogCategory),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(BlogCategoryDestroyRequest $request): JsonResponse
    {
        Cache::forget('blogCategories');
        $blogCategory = BlogCategory::find($request->id);
        if (!$blogCategory) {
            return response()->json([
                'message' => 'BlogCategory not found',
                'alert-type' => 'error'
            ], 404);
        }
        $blogCategory->setActive(false);
        $blogCategory->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(BlogCategoryMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('blogCategories');
        $blogCategorys = BlogCategory::whereIn('id', $request->ids)->get();
        foreach ($blogCategorys as $blogCategory) {
            $blogCategory->setActive(false);
        }
        BlogCategory::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function trash(BlogCategoryTrashRequest $request): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        return BlogCategory::onlyTrashed()
            ->when($request->filled('search'), function ($query) use ($request, $locale) {
                $search = $request->search;
                $query->where(function ($q) use ($search, $locale) {
                    $q->whereRaw('CAST(id AS TEXT) ILIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw("title->>? ILIKE ?", [$locale, '%' . $search . '%']);
                });
            })
            ->orderBy(
                $request->input('sort_column', 'id'),
                $request->input('sort_direction', 'desc')
            )
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function restore(BlogCategoryRestoreRequest $request): JsonResponse
    {
        Cache::forget('blogCategories');
        $blogCategory = BlogCategory::where('id', $request->id)->withTrashed()->first();
        $blogCategory->restore();
        $blogCategory->setActive(false);
        $blogCategory->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function remove(BlogCategoryRemoveRequest $request): JsonResponse
    {
        Cache::forget('blogCategories');
        $blogCategoryId = $request->id;
        $data = BlogCategory::where('id', $blogCategoryId)->withTrashed()->first();
        $data->seo()->forceDelete();
        $data->images()->detach();
        $data->setForceDelete(true);
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function massRemove(BlogCategoryMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('blogCategories');
        $blogCategorys = BlogCategory::withTrashed()->whereIn('id', $request->ids)->get();

        foreach ($blogCategorys as $blogCategory) {
            $blogCategory->seo()->forceDelete();
            $blogCategory->setForceDelete(true);
            $blogCategory->images()->detach();
        }

        BlogCategory::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
}
