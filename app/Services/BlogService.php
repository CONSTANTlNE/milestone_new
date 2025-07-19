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

class BlogService implements BlogInterface
{
    use ImageUploadTrait, MultiTranslatableTrait;

    public function index(BlogIndexRequest $request): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        return Blog::query()
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

    public function getSeoFirst(Blog $blog)
    {
        return $blog->seo()->first();
    }

    public function changeStatus(BlogChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('blogs');

        $blog = Blog::find($data['id']);

        if (!$blog) {
            return response()->json([
                'message' => 'Blog not found',
                'alert-type' => 'error'
            ], 404);
        }

        $blog->update(['status' => $data['status']]);

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(BlogCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('blogs');

        $blog = new Blog();
        $blog->setMultiTranslations($data);
        $blog->status = $data['status'];
        $blog->created_at = $data['published_at'] ?? now();
        $blog->save();

        if (isset($data['category'])) {
            $blog->categories()->sync($data['category']);
        }

        $blog->setSeoTranslations($data);
        $this->processAndSaveImages($data, $blog, true);
        $blog->fresh();

        return response()->json([
            'blog' => BlogResource::make($blog),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Blog $blog): JsonResponse|Blog
    {
        return $blog;
    }

    public function edit(Blog $blog): Blog
    {
        return $blog;
    }

    public function update(BlogUpdateRequest $request, Blog $blog): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('blogs');
        $blog->setMultiTranslations($data);
        $blog->status = $data['status'];
        $blog->created_at = $data['published_at'] ?? now();
        $blog->save();

        if (isset($data['category'])) {
            $blog->categories()->sync($data['category']);
        }else{
            $blog->categories()->detach();
        }

        // Set SEO translations if available
        $blog->setSeoTranslations($data);
        $this->processAndSaveImages($data, $blog, true);
        $blog->fresh();

        return response()->json([
            'blog' => BlogResource::make($blog),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(BlogDestroyRequest $request): JsonResponse
    {
        Cache::forget('blogs');
        $blog = Blog::find($request->id);
        if (!$blog) {
            return response()->json([
                'message' => 'Blog not found',
                'alert-type' => 'error'
            ], 404);
        }
        $blog->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(BlogMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('blogs');

        Blog::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function trash(BlogTrashRequest $request): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        return Blog::onlyTrashed()
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

    public function restore(BlogRestoreRequest $request): JsonResponse
    {
        Cache::forget('blogs');
        $blog = Blog::where('id', $request->id)->withTrashed()->first();
        $blog->restore();
        $blog->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function remove(BlogRemoveRequest $request): JsonResponse
    {
        Cache::forget('blogs');
        $blogId = $request->id;
        $data = Blog::where('id', $blogId)->withTrashed()->first();
        $data->seo()->forceDelete();
        $data->images()->detach();
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function massRemove(BlogMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('blogs');
        $blogs = Blog::withTrashed()->whereIn('id', $request->ids)->get();

        foreach ($blogs as $blog) {
            $blog->seo()->forceDelete();
            $blog->images()->detach();
        }

        Blog::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
}
