<?php

namespace App\Http\Controllers\Backend\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerChangeStatusRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerDestroyRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerIndexRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerMassDestroyRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerMassRemoveRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerRemoveRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerRestoreRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerTrashRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerUpdateRequest;
use App\Services\VehicleManufacturerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Models\VehicleManufacturer;

class VehicleManufacturerController extends Controller
{
    private VehicleManufacturerService $vehicleManufacturerService;

    /**
     * VehicleManufacturerController constructor.
     *
     * @param VehicleManufacturerService $vehicleManufacturerService
     */
    public function __construct(VehicleManufacturerService $vehicleManufacturerService)
    {
        $this->vehicleManufacturerService = $vehicleManufacturerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param VehicleManufacturerIndexRequest $request
     * @return View
     */
    public function index(VehicleManufacturerIndexRequest $request): View
    {
        return view('backend.vehicleManufacturers.index', [
            'vehicleManufacturers' => $this->vehicleManufacturerService->index($request)
        ]);
    }

    /**
     * Change status of the specified resource.
     *
     * @param VehicleManufacturerChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(VehicleManufacturerChangeStatusRequest $request): JsonResponse
    {
        return $this->vehicleManufacturerService->changeStatus($request);
    }

    /**
     * Display the specified resource.
     *
     * @param VehicleManufacturer $vehicleManufacturer
     * @return View
     */
    public function show(VehicleManufacturer $vehicleManufacturer): View
    {
        return view('backend.vehicleManufacturers.show', compact('vehicleManufacturer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param VehicleManufacturer $vehicleManufacturer
     * @return View
     */
    public function edit(VehicleManufacturer $vehicleManufacturer): View
    {
        return view('backend.vehicleManufacturers.edit', compact('vehicleManufacturer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param VehicleManufacturerUpdateRequest $request
     * @param VehicleManufacturer $vehicleManufacturer
     * @return JsonResponse|RedirectResponse
     */
    public function update(VehicleManufacturerUpdateRequest $request, VehicleManufacturer $vehicleManufacturer): JsonResponse|RedirectResponse
    {
        $this->vehicleManufacturerService->update($request, $vehicleManufacturer);
        return redirect()->route('backend.vehicleManufacturers.index')
            ->with('success', 'Vehicle Manufacturer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param VehicleManufacturerDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(VehicleManufacturerDestroyRequest $request): JsonResponse
    {
        return $this->vehicleManufacturerService->destroy($request);
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param VehicleManufacturerMassDestroyRequest $request
     * @return JsonResponse
     */
    public function massDestroy(VehicleManufacturerMassDestroyRequest $request): JsonResponse
    {
        try {
            $this->vehicleManufacturerService->massDestroy($request);
            return response()->json([
                'message' => __('strings.Deleted Successfully')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting vehicle Manufacturer Service: ' . $e->getMessage()
            ], 500);
        }
    }
}
