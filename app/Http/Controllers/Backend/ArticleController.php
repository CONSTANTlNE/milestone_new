<?php

namespace App\Http\Controllers\Backend;

use App\Contracts\ArticleInterface;
use App\DataTables\ArticlesDataTable;
use App\DataTables\ArticlesDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\Article\ArticleCreateRequest;
use App\Http\Requests\Article\ArticleUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\ArticleCategory;
use App\Models\Person;
use App\Models\Region;
use App\Models\User;
use App\Models\Verdict;
use App\Services\ArticleService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Article;
use Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class ArticleController extends Controller
{
    private ArticleService $articleService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
        $this->authorizeResource(Article::class, 'article');
    }

    public function up()
    {
        $articles = Article::where('content', 'like', '%media/image%')->select('content')->limit(5)->get();


        dd($articles);
    }
    /**
     * View all articles.
     *
     * @param ArticlesDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(ArticlesDataTable $dataTable)
    {
        $this->authorize('viewAny', Article::class);
        return $dataTable->render('backend.articles.index');
    }

    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',Article::class);
        try {
            return $this->articleService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status article: ' . $e->getMessage()
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
        $this->authorize('create', Article::class);
        $regions = Region::where('id', '>', 0)->where("status", 1)->pluck('title', 'id');
        $verdicts = Verdict::where('id', '>', 0)->where("status", 1)->where("parent_id", "!=",null)->pluck('title', 'id');
        $persons = Person::where('id', '>', 0)->where("status", 1)->pluck('title', 'id');
        $reporters = User::where("status", 1)->pluck('title', 'id');
        $articleCategires = ArticleCategory::where("status", 1)->pluck('title', 'id');
        return view('backend.articles.create', compact('regions','verdicts', 'persons', 'reporters', 'articleCategires'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleCreateRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(ArticleCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Article::class);
        try {
            $this->articleService->store($request);
            return redirect()->route('backend.articles.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating article: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param Article $article
     * @return JsonResponse|View
     */
    public function show($lang, Article $article): JsonResponse|View
    {
        $this->authorize('view', $article);
        try {
            return view('backend.articles.show', [
                'article' => $this->articleService->show($article)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the article: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param Article $article
     * @return JsonResponse|View
     */
    public function edit($lang, Article $article): JsonResponse|View
    {
        $this->authorize('update', $article);
        try {
            $reporters = User::where("status", 1)->pluck('title', 'id');
            $regions = Region::where('id', '>', 0)->where("status", 1)->pluck('title', 'id');
            $verdicts = Verdict::where('id', '>', 0)->where("status", 1)->where("parent_id", "!=",null)->pluck('title', 'id');
            $persons = Person::where('id', '>', 0)->where("status", 1)->pluck('title', 'id');
            $articleCategories = ArticleCategory::where("status", 1)->pluck('title', 'id');
            return view('backend.articles.edit', [
                'article' => $this->articleService->edit($article),
                'seo' => $this->articleService->getSeoFirst($article),
                'reporters' => $reporters,
                'verdicts' => $verdicts,
                'regions' => $regions,
                'persons' => $persons,
                'articleCategories' => $articleCategories
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the article: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param ArticleUpdateRequest $request
     * @param Article $article
     * @return JsonResponse|View
     */
    public function update($lang, ArticleUpdateRequest $request, Article $article): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $article);
        try {
            $this->articleService->update($request, $article);
            return redirect()->route('backend.articles.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating article: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Article.
     * @param $lang
     * @param Article $article
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, Article $article): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $article);
        try {
            $this->articleService->destroy($article);
            return redirect()->route('backend.articles.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting article: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Article.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', Article::class);
        try {
            $this->articleService->massDestroy($request);
            return redirect()->route('backend.articles.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting article: ' . $e->getMessage()
            ], 500);
        }
    }

    // Archive

    /**
     * View all Articles in Trash.
     *
     * @param ArticlesDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(ArticlesDataTableTrash $dataTable)
    {
        $this->authorize('trash', Article::class);
        return $dataTable->render('backend.articles.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Article::class);
        try {
            $this->articleService->restore($id);
            return redirect()->route('backend.articles.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring article: ' . $e->getMessage()
            ], 500);
        }

    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Article::class);
        try {
            $this->articleService->remove($id);
            return redirect()->route('backend.articles.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing article: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Article::class);
        try {
            $this->articleService->massRemove($request);
            return redirect()->route('backend.articles.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing article: ' . $e->getMessage()
            ], 500);
        }
    }
}
