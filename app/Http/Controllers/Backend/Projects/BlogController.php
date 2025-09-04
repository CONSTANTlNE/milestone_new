<?php

namespace App\Http\Controllers\Backend\Projects;

use App\Http\Requests\Blog\BlogChangeStatusRequest;
use App\Http\Requests\Blog\BlogCreateRequest;
use App\Http\Requests\Blog\BlogDestroyRequest;
use App\Http\Requests\Blog\BlogIndexRequest;
use App\Http\Requests\Blog\BlogMassDestroyRequest;
use App\Http\Requests\Blog\BlogMassRemoveRequest;
use App\Http\Requests\Blog\BlogRemoveRequest;
use App\Http\Requests\Blog\BlogRestoreRequest;
use App\Http\Requests\Blog\BlogTrashRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Models\BlogCategory;
use App\Models\User;
use App\Services\BlogService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Blog;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class BlogController extends Controller
{
    private BlogService $blogService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }
    /**
     * Display a listing of the Blogs.
     * @throws AuthorizationException
     */
    public function index(BlogIndexRequest $request): View
    {
        $this->authorize('viewAny', Blog::class);

        return view('backend.blogs.index', [
            'blogs' => $this->blogService->index($request)
        ]);
    }

    /**
     * Change Status.
     *
     * @param BlogChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(BlogChangeStatusRequest $request): JsonResponse
    {
        return $this->executeOperation(function () use ($request) {
            return $this->blogService->changeStatus($request);
        }, 'Blog Status Change');
    }

    /**
     * Create view the specified resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Blog::class);
        $reporters = User::where("status", 1)->pluck('title', 'id');
        $blogCategories = BlogCategory::where("status", 1)->pluck('title', 'id');
        return view('backend.blogs.create', compact('reporters', 'blogCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogCreateRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function store(BlogCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Blog::class);

        return $this->executeOperation(function () use ($request) {
            $this->blogService->store($request);
            return redirect()->route('backend.blogs.index')
                ->with('success', __('strings.Added Successfully'));
        }, 'Blog Creation');
    }

    /**
     * Display the specified resource.
     *
     * @param Blog $blog
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function show(Blog $blog): JsonResponse|View
    {
        $this->authorize('view', $blog);

        return view('backend.blogs.show', [
            'blog' => $this->blogService->show($blog)
        ]);
    }

    /**
     * Edit the specified resource.
     *
     * @param Blog $blog
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function edit(Blog $blog): JsonResponse|View
    {
        $this->authorize('update', $blog);

        $reporters = User::where("status", 1)->pluck('title', 'id');
        $blogCategories = BlogCategory::where("status", 1)->pluck('title', 'id');
        return view('backend.blogs.edit', [
            'blog' => $this->blogService->edit($blog),
            'seo' => $this->blogService->getSeoFirst($blog),
            'reporters' => $reporters,
            'blogCategories' => $blogCategories
        ]);
    }

    /**
     * Update the specified resource.
     *
     * @param BlogUpdateRequest $request
     * @param Blog $blog
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(BlogUpdateRequest $request, Blog $blog): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $blog);

        return $this->executeOperation(function () use ($request, $blog) {
            $this->blogService->update($request, $blog);
            return redirect()->route('backend.blogs.index')
                ->with('success', __('strings.Updated Successfully'));
        }, 'Blog Update');
    }

    /**
     * Soft Delete Blog.
     * @param BlogDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(BlogDestroyRequest $request): JsonResponse
    {
        return $this->executeOperation(function () use ($request) {
            return $this->blogService->destroy($request);
        }, 'Blog Deletion');
    }

    /**
     * Mass delete blogs.
     */
    public function massDestroy(BlogMassDestroyRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('viewAny', Blog::class);

        return $this->executeOperation(function () use ($request) {
            $this->blogService->massDestroy($request);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => __('strings.Deleted Successfully')
                ], 200);
            }

            return redirect()->route('backend.blogs.index')
                ->with('success', __('strings.Deleted Successfully'));
        }, 'Blog Mass Deletion');
    }

    // Archive
    /**
     * View all blogs in Trash.
     *
     * @param BlogTrashRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function trash(BlogTrashRequest $request): View
    {
        $this->authorize('trash', Blog::class);

        return view('backend.blogs.trash', [
            'blogs' => $this->blogService->trash($request)
        ]);
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param BlogRestoreRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(BlogRestoreRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('restore', Blog::class);

        return $this->executeOperation(function () use ($request) {
            return $this->blogService->restore($request);
        }, 'Blog Restore');
    }

    /**
     * Remove the specified resource permanently.
     *
     * @param BlogRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function remove(BlogRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Blog::class);

        return $this->executeOperation(function () use ($request) {
            return $this->blogService->remove($request);
        }, 'Blog Permanent Deletion');
    }

    /**
     * Mass remove the specified resources permanently.
     *
     * @param BlogMassRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function massRemove(BlogMassRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Blog::class);

        return $this->executeOperation(function () use ($request) {
            $this->blogService->massRemove($request);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => __('strings.Mass Deleted Successfully from Archive')
                ], 200);
            }

            return redirect()->route('backend.blogs.index')
                ->with('success', __('strings.Mass Deleted Successfully from Archive'));
        }, 'Blog Mass Permanent Deletion');
    }
}
