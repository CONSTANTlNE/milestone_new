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
        try {
            return $this->blogService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status Blog: ' . $e->getMessage()
            ], 500);
        }
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
        return view('backend.blogs.create');
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

        try {
            $this->blogService->store($request);
            return redirect()->route('backend.blogs.index')
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating Blog: ' . $e->getMessage()
            ], 500);
        }
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

        try {
            return view('backend.blogs.show', [
                'blog' => $this->blogService->show($blog)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the Blog: ' . $e->getMessage()
            ], 500);
        }
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

        try {
            return view('backend.blogs.edit', [
                'blog' => $this->blogService->edit($blog),
                'seo' => $this->blogService->getSeoFirst($blog)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the Blog: ' . $e->getMessage()
            ], 500);
        }
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

        try {
            $this->blogService->update($request, $blog);
            return redirect()->route('backend.blogs.index')
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating Blog: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft Delete Blog.
     * @param BlogDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(BlogDestroyRequest $request): JsonResponse
    {
        try {
            return $this->blogService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Blog: ' . $e->getMessage()
            ], 500);
        }

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

        try {
            return $this->blogService->restore($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring Blog: ' . $e->getMessage()
            ], 500);
        }
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
        try {
            return $this->blogService->remove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing Blog: ' . $e->getMessage()
            ], 500);
        }
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
        try {
            return $this->blogService->massRemove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass removing Blog: ' . $e->getMessage()
            ], 500);
        }
    }
}
