<?php

namespace App\Http\Controllers\Backend;

use App\Contracts\VersusInterface;
use App\DataTables\VersusDataTable;
use App\DataTables\VersusDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\Versus\VersusCreateRequest;
use App\Http\Requests\Versus\VersusUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\ArticleCategory;
use App\Models\Person;
use App\Models\Region;
use App\Models\User;
use App\Models\Verdict;
use App\Services\VersusService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Article;
use Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class VersusController extends Controller
{
    private VersusService $versusService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(VersusService $versusService)
    {
        $this->versusService = $versusService;
//        $this->authorizeResource(Versus::class, 'versus');
    }
    /**
     * View all Versus.
     *
     * @param VersusDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(VersusDataTable $dataTable)
    {
        $this->authorize('viewAny', Article::class);
        return $dataTable->render('backend.versus.index');
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
            return $this->versusService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status versus: ' . $e->getMessage()
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
        $verdicts = Verdict::where('id', '>', 0)->where("status", 1)->where("parent_id", "!=",null)->pluck('title', 'id');
        $regions = Region::where('id', '>', 0)->where("status", 1)->pluck('title', 'id');
        $persons = Person::where('id', '>', 0)->where("status", 1)->pluck('title', 'id');
        $reporters = User::where("status", 1)->pluck('title', 'id');
        $articleCategires = ArticleCategory::where("status", 1)->pluck('title', 'id');
        return view('backend.versus.create', compact('regions','verdicts', 'persons', 'reporters', 'articleCategires'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VersusCreateRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(VersusCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Article::class);
        try {
            $this->versusService->store($request);
            return redirect()->route('backend.versus.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating versus: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param $id
     * @return JsonResponse|View
     */
    public function show($lang, $id): JsonResponse|View
    {
//        $this->authorize('view', $article);
        try {
            return view('backend.versus.show', [
                'article' => $this->versusService->show($id)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the versus: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param $id
     * @return JsonResponse|View
     */
    public function edit($lang, $id): JsonResponse|View
    {
        //$this->authorize('update', $id);
        try {
            $reporters = User::where("status", 1)->pluck('title', 'id');
            $regions = Region::where('id', '>', 0)->where("status", 1)->pluck('title', 'id');
            $verdicts = Verdict::where('id', '>', 0)->where("status", 1)->where("parent_id", "!=",null)->pluck('title', 'id');
            $persons = Person::where('id', '>', 0)->where("status", 1)->pluck('title', 'id');
            $articleCategories = ArticleCategory::where("status", 1)->pluck('title', 'id');
            return view('backend.versus.edit', [
                'article' => $this->versusService->edit($id),
                'seo' => $this->versusService->getSeoFirst($id),
                'reporters' => $reporters,
                'verdicts' => $verdicts,
                'regions' => $regions,
                'persons' => $persons,
                'articleCategories' => $articleCategories
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the versus: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param VersusUpdateRequest $request
     * @param Article $article
     * @return JsonResponse|View
     */
    public function update($lang, VersusUpdateRequest $request, $id): JsonResponse|RedirectResponse
    {
        //$this->authorize('update', $id);
        try {

            $this->versusService->update($request, $id);
            return redirect()->route('backend.versus.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating versus: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft Delete Versus.
     * @param $lang
     * @param $id
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, $id): JsonResponse|RedirectResponse
    {
        try {
            $article = Article::findOrFail($id);
            $this->versusService->destroy($article);
            return redirect()->route('backend.versus.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting versus: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Versus.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', Article::class);
        try {
            $this->versusService->massDestroy($request);
            return redirect()->route('backend.versus.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting versus: ' . $e->getMessage()
            ], 500);
        }
    }

    // Archive

    /**
     * View all Versus in Trash.
     *
     * @param VersusDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(VersusDataTableTrash $dataTable)
    {
        $this->authorize('trash', Article::class);
        return $dataTable->render('backend.versus.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Article::class);
        try {
            $this->versusService->restore($id);
            return redirect()->route('backend.versus.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring versus: ' . $e->getMessage()
            ], 500);
        }

    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Article::class);
        try {
            $this->versusService->remove($id);
            return redirect()->route('backend.versus.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing versus: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Article::class);
        try {
            $this->versusService->massRemove($request);
            return redirect()->route('backend.versus.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing versus: ' . $e->getMessage()
            ], 500);
        }
    }
}
