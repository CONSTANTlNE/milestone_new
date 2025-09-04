<?php

namespace App\Services;

use App\Http\Requests\VehicleManufacturer\VehicleManufacturerChangeStatusRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerDestroyRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerIndexRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerMassDestroyRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerMassRemoveRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerRemoveRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerRestoreRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerTrashRequest;
use App\Http\Requests\VehicleManufacturer\VehicleManufacturerUpdateRequest;
use App\Models\VehicleManufacturer;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class VehicleManufacturerService
{
    public function index(VehicleManufacturerIndexRequest $request): LengthAwarePaginator
    {
        return VehicleManufacturer::select([
            'id', 
            'legal_business_name', 
            'contact_name', 
            'contact_email', 
            'contact_phone',
            'business_type',
            'years_operation',
            'status',
            'created_at'
        ])
            ->filter($request)
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function changeStatus(VehicleManufacturerChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('vehicle_manufacturers');

        $vehicleManufacturer = VehicleManufacturer::find($data['id']);

        if (!$vehicleManufacturer) {
            return response()->json([
                'message' => 'Vehicle Manufacturer not found',
                'alert-type' => 'error'
            ], 404);
        }

        $vehicleManufacturer->update(['status' => $data['status']]);

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function show(VehicleManufacturer $vehicleManufacturer): VehicleManufacturer
    {
        return $vehicleManufacturer;
    }

    public function edit(VehicleManufacturer $vehicleManufacturer): VehicleManufacturer
    {
        return $vehicleManufacturer;
    }

    public function update(VehicleManufacturerUpdateRequest $request, VehicleManufacturer $vehicleManufacturer): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('vehicle_manufacturers');
        
        $vehicleManufacturer->update($data);
        $vehicleManufacturer->fresh();

        return response()->json([
            'vehicleManufacturer' => $vehicleManufacturer,
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(VehicleManufacturerDestroyRequest $request): JsonResponse
    {
        Cache::forget('vehicle_manufacturers');
        $vehicleManufacturer = VehicleManufacturer::find($request->id);
        
        if (!$vehicleManufacturer) {
            return response()->json([
                'message' => 'Vehicle Manufacturer not found',
                'alert-type' => 'error'
            ], 404);
        }
        
        $vehicleManufacturer->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(VehicleManufacturerMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('vehicle_manufacturers');
        VehicleManufacturer::whereIn('id', $request->ids)->delete();
        
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function trash(VehicleManufacturerTrashRequest $request): LengthAwarePaginator
    {
        return VehicleManufacturer::select(['id', 'legal_business_name', 'contact_name', 'contact_email', 'created_at'])
            ->filterTrash($request)
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function restore(VehicleManufacturerRestoreRequest $request): JsonResponse
    {
        Cache::forget('vehicle_manufacturers');
        $vehicleManufacturer = VehicleManufacturer::where('id', $request->id)->withTrashed()->first();
        
        if (!$vehicleManufacturer) {
            return response()->json([
                'message' => 'Vehicle Manufacturer not found',
                'alert-type' => 'error'
            ], 404);
        }
        
        $vehicleManufacturer->restore();
        $vehicleManufacturer->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function remove(VehicleManufacturerRemoveRequest $request): JsonResponse
    {
        Cache::forget('vehicle_manufacturers');
        $vehicleManufacturerId = $request->id;
        $vehicleManufacturer = VehicleManufacturer::where('id', $vehicleManufacturerId)->withTrashed()->first();
        
        if (!$vehicleManufacturer) {
            return response()->json([
                'message' => 'Vehicle Manufacturer not found',
                'alert-type' => 'error'
            ], 404);
        }
        
        $vehicleManufacturer->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function massRemove(VehicleManufacturerMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('vehicle_manufacturers');

        VehicleManufacturer::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
}
