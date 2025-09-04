<?php

namespace App\Services;

use App\Contracts\BlogInterface;
use App\Http\Requests\Blog\BlogChangeStatusRequest;
use App\Http\Requests\Blog\BlogCreateRequest;
use App\Http\Requests\Blog\BlogDestroyRequest;
use App\Http\Requests\Blog\BlogMassDestroyRequest;
use App\Http\Requests\Blog\BlogMassRemoveRequest;
use App\Http\Requests\Blog\BlogRemoveRequest;
use App\Http\Requests\Blog\BlogRestoreRequest;
use App\Http\Requests\Blog\BlogTrashRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Http\Resources\Blog\BlogResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Blog\BlogIndexRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlogService implements BlogInterface
{
    use ImageUploadTrait, MultiTranslatableTrait;

    private const CACHE_TTL = 3600; // 1 hour
    private const CACHE_PREFIX = 'blogs';

    public function index(BlogIndexRequest $request): LengthAwarePaginator
    {
        return Blog::select(['id', 'title', 'src', 'created_at', 'status'])
            //->with(['categories:id,title,slug', 'reporter:id,name,title'])
            ->filter($request)
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function getSeoFirst(Blog $blog)
    {
        return $blog->seo()->first();
    }

    public function changeStatus(BlogChangeStatusRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $blog = Blog::findOrFail($data['id']);
            $blog->update(['status' => $data['status']]);

            DB::commit();

            return response()->json([
                'message' => __('strings.Status changed successfully'),
                'alert-type' => 'success',
                //'blog' => BlogResource::make($blog)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to change blog status: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    public function store(BlogCreateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $blog = new Blog();
            $blog->setMultiTranslations($data);
            $blog->status = $data['status'];
            $blog->created_at = $data['published_at'] ?? now();

            //if (isset($data['user_id'])) $blog->user_id = $data['user_id'];

            $blog->save();

            if (isset($data['category'])) {
                $blog->categories()->sync($data['category']);
            }

            $blog->setSeoTranslations($data);
            $this->processAndSaveImages($data, $blog, true);
            $blog->fresh();

            DB::commit();

            return response()->json([
                'blog' => BlogResource::make($blog),
                'message' => __('strings.Added Successfully')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create blog: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    public function show(Blog $blog): JsonResponse|Blog
    {
         return $blog->load(['categories', 'reporter', 'images', 'seo']);
    }

    public function edit(Blog $blog): Blog
    {
        return $blog->load(['categories', 'reporter', 'images', 'seo']);
    }

    public function update(BlogUpdateRequest $request, Blog $blog): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $blog->setMultiTranslations($data);
            $blog->status = $data['status'];
            $blog->created_at = $data['published_at'] ?? now();

            // Update new fields if available
//            if (isset($data['user_id'])) $blog->user_id = $data['user_id'];

            $blog->save();

            if (isset($data['category'])) {
                $blog->categories()->sync($data['category']);
            } else {
                $blog->categories()->detach();
            }

            $blog->setSeoTranslations($data);
            $this->processAndSaveImages($data, $blog, true);
            $blog->fresh();

            DB::commit();

            return response()->json([
                'blog' => BlogResource::make($blog),
                'message' => __('strings.Updated Successfully')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update blog: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    public function destroy(BlogDestroyRequest $request): JsonResponse
    {
        try {
            $blog = Blog::findOrFail($request->id);
            $blog->delete();

            return response()->json([
                'message' => __('strings.Deleted Successfully'),
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete blog: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    public function massDestroy(BlogMassDestroyRequest $request): JsonResponse
    {
        try {
            $blogIds = $request->ids;
            Blog::whereIn('id', $blogIds)->delete();
            return response()->json([
                'message' => __('strings.massDestroy Successfully'),
                'deleted_count' => count($blogIds)
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to mass delete blogs: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    // Archive Function Method
    public function trash(BlogTrashRequest $request): LengthAwarePaginator
    {
        return Blog::select(['id', 'title', 'created_at', 'deleted_at'])
            ->withTrashed()
            ->filterTrash($request)
            ->orderBy('deleted_at', 'desc')
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function restore(BlogRestoreRequest $request): JsonResponse
    {
        try {
            $blog = Blog::where('id', $request->id)->withTrashed()->firstOrFail();
            $blog->restore();
            $blog->fresh();
            return response()->json([
                'message' => __('strings.Restored Successfully from Archive'),
                'alert-type' => 'success',
                //'blog' => BlogResource::make($blog)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to restore blog: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    public function remove(BlogRemoveRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $blog = Blog::where('id', $request->id)->withTrashed()->firstOrFail();

            // Force delete all relationships
            $blog->seo()->forceDelete();
            $blog->images()->detach();
            $blog->categories()->detach();
            $blog->forceDelete();

            DB::commit();

            return response()->json([
                'message' => __('strings.Deleted Successfully from Archive'),
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to permanently delete blog: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    public function massRemove(BlogMassRemoveRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $blogIds = $request->ids;

            $blogs = Blog::withTrashed()->whereIn('id', $blogIds)->get();

            foreach ($blogs as $blog) {
                $blog->seo()->forceDelete();
                $blog->images()->detach();
                $blog->categories()->detach();
            }

            Blog::whereIn('id', $blogIds)->withTrashed()->forceDelete();

            DB::commit();

            return response()->json([
                'message' => __('strings.Mass Deleted Successfully from Archive'),
                'deleted_count' => count($blogIds)
            ], 204);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to mass permanently delete blogs: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    // Performance optimization methods
    public function getFeaturedBlogs($limit = 5)
    {
        $cacheKey = $this->getCacheKey('featured', $limit);

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($limit) {
            return Blog::featured()
                ->with(['categories:id,title,slug', 'reporter:id,name,title'])
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    public function getPopularBlogs($limit = 10)
    {
        $cacheKey = $this->getCacheKey('popular', $limit);

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($limit) {
            return Blog::popular($limit)
                ->with(['categories:id,title,slug', 'reporter:id,name,title'])
                ->get();
        });
    }

    public function getRecentBlogs($limit = 10)
    {
        $cacheKey = $this->getCacheKey('recent', $limit);

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($limit) {
            return Blog::recent($limit)
                ->with(['categories:id,title,slug', 'reporter:id,name,title'])
                ->get();
        });
    }

    public function incrementViews(Blog $blog): void
    {
        $blog->incrementViews();
    }
}
