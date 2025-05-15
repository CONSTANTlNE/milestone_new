<?php

namespace App\Http\Controllers\Backend;

use App\Contracts\VerdictInterface;
use App\DataTables\VerdictsDataTable;
use App\DataTables\VerdictsDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\RewriteRequest;
use App\Http\Requests\Verdict\VerdictCreateRequest;
use App\Http\Requests\Verdict\VerdictUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Services\VerdictService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Verdict;
use Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class VerdictController extends Controller
{
    private VerdictService $verdictService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(VerdictService $verdictService)
    {
        $this->verdictService = $verdictService;
        $this->authorizeResource(Verdict::class, 'verdict');
    }
    /**
     * View all verdicts.
     *
     * @param VerdictsDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(VerdictsDataTable $dataTable)
    {
        $this->authorize('viewAny', Verdict::class);
        return $dataTable->render('backend.verdicts.index');
    }

    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',Verdict::class);
        try {
            return $this->verdictService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status verdict: ' . $e->getMessage()
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
        $this->authorize('create', Verdict::class);
        return view('backend.verdicts.create', [
            'verdicts' => $this->verdictService->getVerdictsParent()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VerdictCreateRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(VerdictCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Verdict::class);
        try {
            $this->verdictService->store($request);
            return redirect()->route('backend.verdicts.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating verdict: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rewrite view.
     *
     * @return View
     */
    public function rewrite(): View
    {
        $this->authorize('create', Verdict::class);
        return view('backend.verdicts.rewrite', [
            'verdicts' => $this->verdictService->getVerdicts()
        ]);
    }

    /**
     * Rewrite.
     *
     * @param RewriteRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function rewriteVerdict(RewriteRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Verdict::class);
        try {
            $this->verdictService->rewriteVerdict($request);
            return redirect()->route('backend.verdicts.index', app()->getLocale())
                ->with('success', __('strings.Rewrite Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while rewrite verdict: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param Verdict $verdict
     * @return JsonResponse|View
     */
    public function show($lang, Verdict $verdict): JsonResponse|View
    {
        $this->authorize('view', $verdict);
        try {
            return view('backend.verdicts.show', [
                'verdict' => $this->verdictService->show($verdict)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the verdict: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param Verdict $verdict
     * @return JsonResponse|View
     */
    public function edit($lang, Verdict $verdict): JsonResponse|View
    {
        $this->authorize('update', $verdict);
        try {
            return view('backend.verdicts.edit', [
                'verdict' => $this->verdictService->edit($verdict),
                'verdicts' => $this->verdictService->getVerdictsParent(),
                'seo' => $this->verdictService->getSeoFirst($verdict)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the verdict: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param Verdict $verdict
     * @return JsonResponse|View
     */
    public function update($lang, VerdictUpdateRequest $request, Verdict $verdict): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $verdict);
        try {
            $this->verdictService->update($request, $verdict);
            return redirect()->route('backend.verdicts.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating user: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Verdict.
     * @param $lang
     * @param Verdict $verdict
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, Verdict $verdict): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $verdict);
        try {
            $this->verdictService->destroy($verdict);
            return redirect()->route('backend.verdicts.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting verdict: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Verdict.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', Verdict::class);
        try {
            $this->verdictService->massDestroy($request);
            return redirect()->route('backend.verdicts.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting verdict: ' . $e->getMessage()
            ], 500);
        }
    }

    // Archive

    /**
     * View all Verdicts in Trash.
     *
     * @param VerdictsDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(VerdictsDataTableTrash $dataTable)
    {
        $this->authorize('trash', Verdict::class);
        return $dataTable->render('backend.verdicts.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Verdict::class);
        try {
            $this->verdictService->restore($id);
            return redirect()->route('backend.verdicts.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring verdict: ' . $e->getMessage()
            ], 500);
        }

    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Verdict::class);
        try {
            $this->verdictService->remove($id);
            return redirect()->route('backend.verdicts.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing verdict: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Verdict::class);
        try {
            $this->verdictService->massRemove($request);
            return redirect()->route('backend.verdicts.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing verdict: ' . $e->getMessage()
            ], 500);
        }
    }
}
