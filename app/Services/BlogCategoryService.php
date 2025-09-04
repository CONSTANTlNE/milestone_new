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
        $cacheKey = $this->getCacheKey('index', $request->all());
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($request) {
            return BlogCategory::select(['id', 'title', 'src', 'created_at', 'status', 'sort_order', 'featured'])
                ->with(['blogs' => function($query) {
                    $query->where('status', true)->select('id');
                }])
                ->withCount(['blogs' => function($query) {
                    $query->where('status', true);
                }])
                ->filter($request)
                ->orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate($request->input('per_page', 10))
                ->appends($request->query());
        });
    }

    public function getSeoFirst(BlogCategory $blogCategory)
    {
        $cacheKey = $this->getCacheKey('seo', $blogCategory->id);
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($blogCategory) {
            return $blogCategory->seo()->first();
        });
    }

    public function changeStatus(BlogCategoryChangeStatusRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            
            $data = $request->validated();
            $this->clearBlogCategoryCache();

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
            Log::error('BlogCategory status change failed: ' . $e->getMessage(), [
                'category_id' => $data['id'] ?? null,
                'status' => $data['status'] ?? null
            ]);
            
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
            $this->clearBlogCategoryCache();

            $blogCategory = new BlogCategory();
            $blogCategory->setMultiTranslations($data);
            $blogCategory->status = $data['status'];
            $blogCategory->created_at = $data['published_at'] ?? now();
            
            // Set new fields if available
            if (isset($data['meta_title'])) $blogCategory->meta_title = $data['meta_title'];
            if (isset($data['meta_description'])) $blogCategory->meta_description = $data['meta_description'];
            if (isset($data['meta_keywords'])) $blogCategory->meta_keywords = $data['meta_keywords'];
            if (isset($data['sort_order'])) $blogCategory->sort_order = $data['sort_order'];
            if (isset($data['featured'])) $blogCategory->featured = $data['featured'];
            if (isset($data['parent_id'])) $blogCategory->parent_id = $data['parent_id'];
            
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
            Log::error('BlogCategory creation failed: ' . $e->getMessage(), [
                'data' => $data ?? null
            ]);
            
            return response()->json([
                'message' => 'Failed to create blog category: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    public function show(BlogCategory $blogCategory): JsonResponse|BlogCategory
    {
        $cacheKey = $this->getCacheKey('show', $blogCategory->id);
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($blogCategory) {
            return $blogCategory->load(['blogs', 'images', 'seo', 'parent']);
        });
    }

    public function edit(BlogCategory $blogCategory): BlogCategory
    {
        return $blogCategory->load(['blogs', 'images', 'seo', 'parent']);
    }

    public function update(BlogCategoryUpdateRequest $request, BlogCategory $blogCategory): JsonResponse
    {
        try {
            DB::beginTransaction();
            
            $data = $request->validated();
            $this->clearBlogCategoryCache();
            
            $blogCategory->setMultiTranslations($data);
            $blogCategory->status = $data['status'];
            $blogCategory->created_at = $data['published_at'] ?? now();
            
            // Update new fields if available
            if (isset($data['meta_title'])) $blogCategory->meta_title = $data['meta_title'];
            if (isset($data['meta_description'])) $blogCategory->meta_description = $data['meta_description'];
            if (isset($data['meta_keywords'])) $blogCategory->meta_keywords = $data['meta_keywords'];
            if (isset($data['sort_order'])) $blogCategory->sort_order = $data['sort_order'];
            if (isset($data['featured'])) $blogCategory->featured = $data['featured'];
            if (isset($data['parent_id'])) $blogCategory->parent_id = $data['parent_id'];
            
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
            Log::error('BlogCategory update failed: ' . $e->getMessage(), [
                'category_id' => $blogCategory->id,
                'data' => $data ?? null
            ]);
            
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
            
            $this->clearBlogCategoryCache();
            $blogCategory = BlogCategory::findOrFail($request->id);
            
            // Detach relationships before deletion
            $blogCategory->blogs()->detach();
            $blogCategory->images()->detach();
            $blogCategory->seo()->delete();
            $blogCategory->setActive(false);
            
            $blogCategory->delete();

            DB::commit();

            return response()->json([
                'message' => __('strings.Deleted Successfully'),
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('BlogCategory deletion failed: ' . $e->getMessage(), [
                'category_id' => $request->id
            ]);
            
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
            
            $this->clearBlogCategoryCache();
            $categoryIds = $request->ids;
            
            $blogCategories = BlogCategory::whereIn('id', $categoryIds)->get();
            
            foreach ($blogCategories as $blogCategory) {
                $blogCategory->blogs()->detach();
                $blogCategory->images()->detach();
                $blogCategory->seo()->delete();
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
            Log::error('BlogCategory mass deletion failed: ' . $e->getMessage(), [
                'category_ids' => $request->ids
            ]);
            
            return response()->json([
                'message' => 'Failed to mass delete blog categories: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    // Archive Function Method
    public function trash(BlogCategoryTrashRequest $request): LengthAwarePaginator
    {
        $cacheKey = $this->getCacheKey('trash', $request->all());
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($request) {
            return BlogCategory::select(['id', 'title', 'created_at', 'deleted_at'])
                ->withTrashed()
                ->filterTrash($request)
                ->orderBy('deleted_at', 'desc')
                ->paginate($request->input('per_page', 10))
                ->appends($request->query());
        });
    }

    public function restore(BlogCategoryRestoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            
            $this->clearBlogCategoryCache();
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
            Log::error('BlogCategory restore failed: ' . $e->getMessage(), [
                'category_id' => $request->id
            ]);
            
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
            
            $this->clearBlogCategoryCache();
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
            Log::error('BlogCategory permanent deletion failed: ' . $e->getMessage(), [
                'category_id' => $request->id
            ]);
            
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
            
            $this->clearBlogCategoryCache();
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
            Log::error('BlogCategory mass permanent deletion failed: ' . $e->getMessage(), [
                'category_ids' => $request->ids
            ]);
            
            return response()->json([
                'message' => 'Failed to mass permanently delete blog categories: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    // Performance optimization methods
    public function getActiveCategories()
    {
        $cacheKey = $this->getCacheKey('active', 'all');
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            return BlogCategory::active()
                ->ordered()
                ->withCount(['blogs' => function($query) {
                    $query->where('status', true);
                }])
                ->get();
        });
    }

    public function getFeaturedCategories($limit = 5)
    {
        $cacheKey = $this->getCacheKey('featured', $limit);
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($limit) {
            return BlogCategory::featured()
                ->withCount(['blogs' => function($query) {
                    $query->where('status', true);
                }])
                ->limit($limit)
                ->get();
        });
    }

    public function getCategoryWithBlogs($categoryId, $perPage = 12)
    {
        $cacheKey = $this->getCacheKey('category_with_blogs', $categoryId . '_' . $perPage);
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($categoryId, $perPage) {
            return BlogCategory::with(['blogs' => function($query) use ($perPage) {
                $query->where('status', true)
                      ->orderBy('created_at', 'desc')
                      ->paginate($perPage);
            }])
            ->findOrFail($categoryId);
        });
    }

    public function searchCategories($search, $perPage = 12)
    {
        $cacheKey = $this->getCacheKey('search', $search . '_' . $perPage);
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($search, $perPage) {
            return BlogCategory::search($search)
                ->active()
                ->withCount(['blogs' => function($query) {
                    $query->where('status', true);
                }])
                ->orderBy('sort_order', 'asc')
                ->paginate($perPage);
        });
    }

    // Cache management methods
    private function getCacheKey(string $type, $identifier): string
    {
        $identifier = is_array($identifier) ? md5(serialize($identifier)) : $identifier;
        return self::CACHE_PREFIX . "_{$type}_{$identifier}";
    }

    private function clearBlogCategoryCache(): void
    {
        Cache::forget('blogs');
        Cache::forget('blogCategories');
        
        // Clear specific cache patterns
        Cache::forget(self::CACHE_PREFIX . '_active_*');
        Cache::forget(self::CACHE_PREFIX . '_featured_*');
        Cache::forget(self::CACHE_PREFIX . '_category_with_blogs_*');
        Cache::forget(self::CACHE_PREFIX . '_search_*');
    }
}
