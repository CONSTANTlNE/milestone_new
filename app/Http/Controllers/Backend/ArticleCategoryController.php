<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ArticleCategoryDataTable;
use App\DataTables\ArticleCategoryDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\ArticleCategory\ArticleCategoryCreateRequest;
use App\Http\Requests\ArticleCategory\ArticleCategoryUpdateRequest;
use App\Services\ArticleCategoryService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\ArticleCategory;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class ArticleCategoryController extends Controller
{
    private ArticleCategoryService $articleCategoryService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(ArticleCategoryService $articleCategoryService)
    {
        $this->articleCategoryService = $articleCategoryService;
        $this->authorizeResource(ArticleCategory::class, 'articleCategory');
    }
    /**
     * View all Article Category.
     *
     * @param ArticleCategoryDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(ArticleCategoryDataTable $dataTable)
    {
        $this->authorize('viewAny', ArticleCategory::class);
        return $dataTable->render('backend.articleCategory.index');
    }

    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',ArticleCategory::class);
        try {
            return $this->articleCategoryService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status Article Category: ' . $e->getMessage()
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
        $this->authorize('create', ArticleCategory::class);
        return view('backend.articleCategory.create', [
            'articleCategories' => $this->articleCategoryService->getArticleCategoriesParent()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleCategoryCreateRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(ArticleCategoryCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', ArticleCategory::class);
        try {
            $this->articleCategoryService->store($request);
            return redirect()->route('backend.articleCategory.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating Article Category: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param ArticleCategory $articleCategory
     * @return JsonResponse|View
     */
    public function show($lang, ArticleCategory $articleCategory): JsonResponse|View
    {
        $this->authorize('view', $articleCategory);
        try {
            return view('backend.articleCategory.show', [
                'articleCategory' => $this->articleCategoryService->show($articleCategory)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the Article Category: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param ArticleCategory $articleCategory
     * @return JsonResponse|View
     */
    public function edit($lang, ArticleCategory $articleCategory): JsonResponse|View
    {
        $this->authorize('update', $articleCategory);
        try {
            return view('backend.articleCategory.edit', [
                'articleCategory' => $this->articleCategoryService->edit($articleCategory),
                'articleCategories' => $this->articleCategoryService->getArticleCategoriesParent(),
                'seo' => $this->articleCategoryService->getSeoFirst($articleCategory)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the Article Category: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param ArticleCategory $articleCategory
     * @return JsonResponse|View
     */
    public function update($lang, ArticleCategoryUpdateRequest $request, ArticleCategory $articleCategory): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $articleCategory);
        try {
            $this->articleCategoryService->update($request, $articleCategory);
            return redirect()->route('backend.articleCategory.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating Article Category: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Article Category.
     * @param $lang
     * @param ArticleCategory $articleCategory
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, ArticleCategory $articleCategory): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $articleCategory);
        try {
            $this->articleCategoryService->destroy($articleCategory);
            return redirect()->route('backend.articleCategory.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Article Category: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Article Category.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', ArticleCategory::class);
        try {
            $this->articleCategoryService->massDestroy($request);
            return redirect()->route('backend.articleCategory.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting Article Category: ' . $e->getMessage()
            ], 500);
        }
    }

    // Archive

    /**
     * View all Article Category in Trash.
     *
     * @param ArticleCategoryDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(ArticleCategoryDataTableTrash $dataTable)
    {
        $this->authorize('trash', ArticleCategory::class);
        return $dataTable->render('backend.articleCategory.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', ArticleCategory::class);
        try {
            $this->articleCategoryService->restore($id);
            return redirect()->route('backend.articleCategory.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring Article Category: ' . $e->getMessage()
            ], 500);
        }

    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', ArticleCategory::class);
        try {
            $this->articleCategoryService->remove($id);
            return redirect()->route('backend.articleCategory.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing Article Category: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', ArticleCategory::class);
        try {
            $this->articleCategoryService->massRemove($request);
            return redirect()->route('backend.articleCategory.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing Article Category: ' . $e->getMessage()
            ], 500);
        }
    }
}
