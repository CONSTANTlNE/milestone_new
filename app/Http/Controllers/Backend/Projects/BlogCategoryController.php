<?php

namespace App\Http\Controllers\Backend\Projects;

use App\Http\Requests\BlogCategory\BlogCategoryChangeStatusRequest;
use App\Http\Requests\BlogCategory\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategory\BlogCategoryDestroyRequest;
use App\Http\Requests\BlogCategory\BlogCategoryIndexRequest;
use App\Http\Requests\BlogCategory\BlogCategoryMassDestroyRequest;
use App\Http\Requests\BlogCategory\BlogCategoryMassRemoveRequest;
use App\Http\Requests\BlogCategory\BlogCategoryRemoveRequest;
use App\Http\Requests\BlogCategory\BlogCategoryRestoreRequest;
use App\Http\Requests\BlogCategory\BlogCategoryTrashRequest;
use App\Http\Requests\BlogCategory\BlogCategoryUpdateRequest;
use App\Services\BlogCategoryService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\BlogCategory;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    private BlogCategoryService $blogCategoryService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(BlogCategoryService $blogCategoryService)
    {
        $this->blogCategoryService = $blogCategoryService;
    }

    /**
     * Display a listing of the BlogCategories.
     * @throws AuthorizationException
     */
    public function index(BlogCategoryIndexRequest $request): View
    {
        $this->authorize('viewAny', BlogCategory::class);

        return view('backend.blogCategories.index', [
            'blogCategories' => $this->blogCategoryService->index($request)
        ]);
    }

    /**
     * Change Status.
     *
     * @param BlogCategoryChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(BlogCategoryChangeStatusRequest $request): JsonResponse
    {
        try {
            return $this->blogCategoryService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status BlogCategory: ' . $e->getMessage()
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
        $this->authorize('create', BlogCategory::class);
        return view('backend.blogCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogCategoryCreateRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function store(BlogCategoryCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', BlogCategory::class);

        try {
            $this->blogCategoryService->store($request);
            return redirect()->route('backend.blogCategories.index')
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating BlogCategory: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param BlogCategory $blogCategory
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function show(BlogCategory $blogCategory): JsonResponse|View
    {
        $this->authorize('view', $blogCategory);

        try {
            return view('backend.blogCategories.show', [
                'blogCategory' => $this->blogCategoryService->show($blogCategory)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the BlogCategory: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param BlogCategory $blogCategory
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function edit(BlogCategory $blogCategory): JsonResponse|View
    {
        $this->authorize('update', $blogCategory);

        try {
            return view('backend.blogCategories.edit', [
                'blogCategory' => $this->blogCategoryService->edit($blogCategory),
                'seo' => $this->blogCategoryService->getSeoFirst($blogCategory)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the BlogCategory: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param BlogCategoryUpdateRequest $request
     * @param BlogCategory $blogCategory
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(BlogCategoryUpdateRequest $request, BlogCategory $blogCategory): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $blogCategory);

        try {
            $this->blogCategoryService->update($request, $blogCategory);
            return redirect()->route('backend.blogCategories.index')
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating BlogCategory: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft Delete BlogCategory.
     * @param BlogCategoryDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(BlogCategoryDestroyRequest $request): JsonResponse
    {
        try {
            return $this->blogCategoryService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting BlogCategory: ' . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Mass delete BlogCategories.
     */
    public function massDestroy(BlogCategoryMassDestroyRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('viewAny', BlogCategory::class);

        return $this->executeOperation(function () use ($request) {
            $this->blogCategoryService->massDestroy($request);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => __('strings.Deleted Successfully')
                ], 200);
            }

            return redirect()->route('backend.blogCategories.index')
                ->with('success', __('strings.Deleted Successfully'));
        }, 'BlogCategory Mass Deletion');
    }

    // Archive
    /**
     * View all BlogCategory in Trash.
     *
     * @param BlogCategoryTrashRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function trash(BlogCategoryTrashRequest $request): View
    {
        $this->authorize('trash', BlogCategory::class);

        return view('backend.blogCategories.trash', [
            'blogCategories' => $this->blogCategoryService->trash($request)
        ]);
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param BlogCategoryRestoreRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(BlogCategoryRestoreRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('restore', BlogCategory::class);

        try {
            return $this->blogCategoryService->restore($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring BlogCategory: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource permanently.
     *
     * @param BlogCategoryRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function remove(BlogCategoryRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', BlogCategory::class);
        try {
            return $this->blogCategoryService->remove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing BlogCategory: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass remove the specified resources permanently.
     *
     * @param BlogCategoryMassRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function massRemove(BlogCategoryMassRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', BlogCategory::class);
        try {
            return $this->blogCategoryService->massRemove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass removing BlogCategory: ' . $e->getMessage()
            ], 500);
        }
    }
}
