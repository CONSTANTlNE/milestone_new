<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Page\PageChangeStatusRequest;
use App\Http\Requests\Page\PageCreateRequest;
use App\Http\Requests\Page\PageDestroyRequest;
use App\Http\Requests\Page\PageIndexRequest;
use App\Http\Requests\Page\PageMassDestroyRequest;
use App\Http\Requests\Page\PageMassRemoveRequest;
use App\Http\Requests\Page\PageRemoveRequest;
use App\Http\Requests\Page\PageRestoreRequest;
use App\Http\Requests\Page\PageTrashRequest;
use App\Http\Requests\Page\PageUpdateRequest;
use App\Services\PageService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    private PageService $pageService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }
    /**
     * Display a listing of the Pages.
     * @throws AuthorizationException
     */
    public function index(PageIndexRequest $request): View
    {
        $this->authorize('viewAny', Page::class);

        return view('backend.pages.index', [
            'pages' => $this->pageService->index($request)
        ]);
    }

    /**
     * Change Status.
     *
     * @param PageChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(PageChangeStatusRequest $request): JsonResponse
    {
        try {
            return $this->pageService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status page: ' . $e->getMessage()
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
        $this->authorize('create', Page::class);
        return view('backend.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PageCreateRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function store(PageCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Page::class);

        try {
            $this->pageService->store($request);
            return redirect()->route('backend.pages.index')
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating page: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Page $page
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function show(Page $page): JsonResponse|View
    {
        $this->authorize('view', $page);

        try {
            return view('backend.pages.show', [
                'page' => $this->pageService->show($page)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the page: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param Page $page
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function edit(Page $page): JsonResponse|View
    {
        $this->authorize('update', $page);

        try {
            return view('backend.pages.edit', [
                'page' => $this->pageService->edit($page),
                'seo' => $this->pageService->getSeoFirst($page)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the page: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param PageUpdateRequest $request
     * @param Page $page
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(PageUpdateRequest $request, Page $page): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $page);

        try {
            $this->pageService->update($request, $page);
            return redirect()->route('backend.pages.index')
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating page: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft Delete Page.
     * @param PageDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(PageDestroyRequest $request): JsonResponse
    {
        try {
            return $this->pageService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting page: ' . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Mass delete pages.
     */
    public function massDestroy(PageMassDestroyRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('viewAny', Page::class);

        return $this->executeOperation(function () use ($request) {
            $this->pageService->massDestroy($request);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => __('strings.Deleted Successfully')
                ], 200);
            }

            return redirect()->route('backend.pages.index')
                ->with('success', __('strings.Deleted Successfully'));
        }, 'Page Mass Deletion');
    }

    // Archive
    /**
     * View all Pages in Trash.
     *
     * @param PageTrashRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function trash(PageTrashRequest $request): View
    {
        $this->authorize('trash', Page::class);

        return view('backend.pages.trash', [
            'pages' => $this->pageService->trash($request)
        ]);
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param PageRestoreRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(PageRestoreRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('restore', Page::class);

        try {
            return $this->pageService->restore($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring page: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource permanently.
     *
     * @param PageRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function remove(PageRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Page::class);
        try {
            return $this->pageService->remove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing page: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass remove the specified resources permanently.
     *
     * @param PageMassRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function massRemove(PageMassRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Page::class);
        try {
            return $this->pageService->massRemove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass removing page: ' . $e->getMessage()
            ], 500);
        }
    }
}
