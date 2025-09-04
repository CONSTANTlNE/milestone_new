<?php

namespace App\Http\Controllers\Backend\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetChangeStatusRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetDestroyRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetIndexRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetMassDestroyRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetMassRemoveRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetRemoveRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetRestoreRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetTrashRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetUpdateRequest;
use App\Services\CorporateGovernmentFleetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Models\CorporateGovernmentFleet;

class CorporateGovernmentFleetController extends Controller
{
    private CorporateGovernmentFleetService $corporateGovernmentFleetService;

    /**
     * CorporateGovernmentFleetController constructor.
     *
     * @param CorporateGovernmentFleetService $corporateGovernmentFleetService
     */
    public function __construct(CorporateGovernmentFleetService $corporateGovernmentFleetService)
    {
        $this->corporateGovernmentFleetService = $corporateGovernmentFleetService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param CorporateGovernmentFleetIndexRequest $request
     * @return View
     */
    public function index(CorporateGovernmentFleetIndexRequest $request): View
    {
        return view('backend.corporateGovernmentFleets.index', [
            'corporateGovernmentFleets' => $this->corporateGovernmentFleetService->index($request)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param CorporateGovernmentFleet $corporateGovernmentFleet
     * @return View
     */
    public function show(CorporateGovernmentFleet $corporateGovernmentFleet): View
    {
        return view('backend.corporateGovernmentFleets.show', compact('corporateGovernmentFleet'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CorporateGovernmentFleetDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(CorporateGovernmentFleetDestroyRequest $request): JsonResponse
    {
        return $this->corporateGovernmentFleetService->destroy($request);
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param CorporateGovernmentFleetMassDestroyRequest $request
     * @return JsonResponse
     */
    public function massDestroy(CorporateGovernmentFleetMassDestroyRequest $request): JsonResponse
    {
        try {
            $this->corporateGovernmentFleetService->massDestroy($request);
            return response()->json([
                'message' => __('strings.Deleted Successfully')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting corporateGovernmentFleetService: ' . $e->getMessage()
            ], 500);
        }
    }
}
