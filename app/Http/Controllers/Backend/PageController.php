<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\PagesDataTable;
use App\DataTables\PagesDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\Page\PageCreateRequest;
use App\Http\Requests\Page\PageUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Services\PageService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

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
        $this->authorizeResource(Page::class, 'page');
    }
    /**
     * View all Pages.
     *
     * @param PagesDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(PagesDataTable $dataTable)
    {
        $this->authorize('viewAny', Page::class);
        return $dataTable->render('backend.pages.index');
    }

    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',Page::class);
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
     */
    public function store(PageCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Page::class);
        try {
            $this->pageService->store($request);
            return redirect()->route('backend.pages.index', app()->getLocale())
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
     * @param $lang
     * @param Page $page
     * @return JsonResponse|View
     */
    public function show($lang, Page $page): JsonResponse|View
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
     * @param $lang
     * @param Page $page
     * @return JsonResponse|View
     */
    public function edit($lang, Page $page): JsonResponse|View
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
     * @param $lang
     * @param Page $page
     * @return JsonResponse|View
     */
    public function update($lang, PageUpdateRequest $request, Page $page): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $page);
        try {
            $this->pageService->update($request, $page);
            return redirect()->route('backend.pages.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating user: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Page.
     * @param $lang
     * @param Page $page
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, Page $page): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $page);
        try {
            $this->pageService->destroy($page);
            return redirect()->route('backend.pages.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting page: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Page.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', Page::class);
        try {
            $this->pageService->massDestroy($request);
            return redirect()->route('backend.pages.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting page: ' . $e->getMessage()
            ], 500);
        }
    }

    // Archive

    /**
     * View all Pages in Trash.
     *
     * @param PagesDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(PagesDataTableTrash $dataTable)
    {
        $this->authorize('trash', Page::class);
        return $dataTable->render('backend.pages.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Page::class);
        try {
            $this->pageService->restore($id);
            return redirect()->route('backend.pages.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring page: ' . $e->getMessage()
            ], 500);
        }

    }

    public function remove(RemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Page::class);
        try {
            $this->pageService->remove($request);
            return redirect()->route('backend.pages.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing page: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Page::class);
        try {
            $this->pageService->massRemove($request);
            return redirect()->route('backend.pages.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing page: ' . $e->getMessage()
            ], 500);
        }
    }
}
