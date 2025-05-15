<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\RegionsDataTable;
use App\DataTables\RegionsDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\Region\RegionCreateRequest;
use App\Http\Requests\Region\RegionUpdateRequest;
use App\Http\Requests\RewriteRequest;
use App\Services\RegionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Region;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class RegionController extends Controller
{
    private RegionService $regionService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
        $this->authorizeResource(Region::class, 'region');
    }
    /**
     * View all Region.
     *
     * @param RegionsDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(RegionsDataTable $dataTable)
    {
        $this->authorize('viewAny', Region::class);
        return $dataTable->render('backend.regions.index');
    }

    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',Region::class);
        try {
            return $this->regionService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status Region: ' . $e->getMessage()
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
        $this->authorize('create', Region::class);
        return view('backend.regions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RegionCreateRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(RegionCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Region::class);
        try {
            $this->regionService->store($request);
            return redirect()->route('backend.regions.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating Region: ' . $e->getMessage()
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
        $this->authorize('create', Region::class);
        return view('backend.regions.rewrite', [
            'regions' => $this->regionService->getRegions()
        ]);
    }

    /**
     * Rewrite.
     *
     * @param RewriteRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function rewriteRegion(RewriteRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Region::class);
        try {
            $this->regionService->rewriteRegion($request);
            return redirect()->route('backend.regions.index', app()->getLocale())
                ->with('success', __('strings.Rewrite Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while rewrite region: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param Region $region
     * @return JsonResponse|View
     */
    public function show($lang, Region $region): JsonResponse|View
    {
        $this->authorize('view', $region);
        try {
            return view('backend.regions.show', [
                'region' => $this->regionService->show($region)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the Region: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param Region $region
     * @return JsonResponse|View
     */
    public function edit($lang, Region $region): JsonResponse|View
    {
        $this->authorize('update', $region);
        try {
            return view('backend.regions.edit', [
                'region' => $this->regionService->edit($region),
                'seo' => $this->regionService->getSeoFirst($region)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the Region: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param Region $region
     * @return JsonResponse|View
     */
    public function update($lang, RegionUpdateRequest $request, Region $region): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $region);
        try {
            $this->regionService->update($request, $region);
            return redirect()->route('backend.regions.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating Region: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Region.
     * @param $lang
     * @param Region $region
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, Region $region): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $region);
        try {
            $this->regionService->destroy($region);
            return redirect()->route('backend.regions.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Region: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Region.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', Region::class);
        try {
            $this->regionService->massDestroy($request);
            return redirect()->route('backend.regions.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting Region: ' . $e->getMessage()
            ], 500);
        }
    }

    // Archive

    /**
     * View all Region in Trash.
     *
     * @param RegionsDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(RegionsDataTableTrash $dataTable)
    {
        $this->authorize('trash', Region::class);
        return $dataTable->render('backend.regions.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Region::class);
        try {
            $this->regionService->restore($id);
            return redirect()->route('backend.regions.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring Region: ' . $e->getMessage()
            ], 500);
        }

    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Region::class);
        try {
            $this->regionService->remove($id);
            return redirect()->route('backend.regions.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing Region: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Region::class);
        try {
            $this->regionService->massRemove($request);
            return redirect()->route('backend.regions.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing Region: ' . $e->getMessage()
            ], 500);
        }
    }
}
