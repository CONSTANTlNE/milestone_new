<?php

namespace App\Http\Controllers\Backend\Projects;

use App\Http\Requests\Portfolio\PortfolioChangeStatusRequest;
use App\Http\Requests\Portfolio\PortfolioCreateRequest;
use App\Http\Requests\Portfolio\PortfolioDestroyRequest;
use App\Http\Requests\Portfolio\PortfolioIndexRequest;
use App\Http\Requests\Portfolio\PortfolioMassDestroyRequest;
use App\Http\Requests\Portfolio\PortfolioMassRemoveRequest;
use App\Http\Requests\Portfolio\PortfolioRemoveRequest;
use App\Http\Requests\Portfolio\PortfolioRestoreRequest;
use App\Http\Requests\Portfolio\PortfolioTrashRequest;
use App\Http\Requests\Portfolio\PortfolioUpdateRequest;
use App\Services\PortfolioService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Portfolio;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    private PortfolioService $portfolioService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(PortfolioService $portfolioService)
    {
        $this->portfolioService = $portfolioService;
    }
    /**
     * Display a listing of the Portfolios.
     * @throws AuthorizationException
     */
    public function index(PortfolioIndexRequest $request): View
    {
        $this->authorize('viewAny', Portfolio::class);

        return view('backend.portfolios.index', [
            'portfolios' => $this->portfolioService->index($request)
        ]);
    }

    /**
     * Change Status.
     *
     * @param PortfolioChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(PortfolioChangeStatusRequest $request): JsonResponse
    {
        try {
            return $this->portfolioService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status Portfolio: ' . $e->getMessage()
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
        $this->authorize('create', Portfolio::class);
        return view('backend.portfolios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PortfolioCreateRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function store(PortfolioCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Portfolio::class);

        try {
            $this->portfolioService->store($request);
            return redirect()->route('backend.portfolios.index')
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating Portfolio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Portfolio $portfolio
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function show(Portfolio $portfolio): JsonResponse|View
    {
        $this->authorize('view', $portfolio);

        try {
            return view('backend.portfolios.show', [
                'portfolio' => $this->portfolioService->show($portfolio)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the Portfolio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param Portfolio $portfolio
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function edit(Portfolio $portfolio): JsonResponse|View
    {
        $this->authorize('update', $portfolio);

        try {
            return view('backend.portfolios.edit', [
                'portfolio' => $this->portfolioService->edit($portfolio),
                'seo' => $this->portfolioService->getSeoFirst($portfolio)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the Portfolio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param PortfolioUpdateRequest $request
     * @param Portfolio $portfolio
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(PortfolioUpdateRequest $request, Portfolio $portfolio): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $portfolio);

        try {
            $this->portfolioService->update($request, $portfolio);
            return redirect()->route('backend.portfolios.index')
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating Portfolio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft Delete Portfolio.
     * @param PortfolioDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(PortfolioDestroyRequest $request): JsonResponse
    {
        try {
            return $this->portfolioService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Portfolio: ' . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Mass delete portfolios.
     */
    public function massDestroy(PortfolioMassDestroyRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('viewAny', Portfolio::class);

        return $this->executeOperation(function () use ($request) {
            $this->portfolioService->massDestroy($request);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => __('strings.Deleted Successfully')
                ], 200);
            }

            return redirect()->route('backend.portfolios.index')
                ->with('success', __('strings.Deleted Successfully'));
        }, 'Portfolio Mass Deletion');
    }

    // Archive
    /**
     * View all Portfolio in Trash.
     *
     * @param PortfolioTrashRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function trash(PortfolioTrashRequest $request): View
    {
        $this->authorize('trash', Portfolio::class);

        return view('backend.portfolios.trash', [
            'portfolios' => $this->portfolioService->trash($request)
        ]);
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param PortfolioRestoreRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(PortfolioRestoreRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('restore', Portfolio::class);

        try {
            return $this->portfolioService->restore($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring Portfolio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource permanently.
     *
     * @param PortfolioRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function remove(PortfolioRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Portfolio::class);
        try {
            return $this->portfolioService->remove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing Portfolio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass remove the specified resources permanently.
     *
     * @param PortfolioMassRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function massRemove(PortfolioMassRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Portfolio::class);
        try {
            return $this->portfolioService->massRemove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass removing Portfolio: ' . $e->getMessage()
            ], 500);
        }
    }
}
