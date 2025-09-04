<?php

namespace App\Services;

use App\Http\Requests\CarRetailer\CarRetailerChangeStatusRequest;
use App\Http\Requests\CarRetailer\CarRetailerDestroyRequest;
use App\Http\Requests\CarRetailer\CarRetailerIndexRequest;
use App\Http\Requests\CarRetailer\CarRetailerMassDestroyRequest;
use App\Http\Requests\CarRetailer\CarRetailerMassRemoveRequest;
use App\Http\Requests\CarRetailer\CarRetailerRemoveRequest;
use App\Http\Requests\CarRetailer\CarRetailerRestoreRequest;
use App\Http\Requests\CarRetailer\CarRetailerTrashRequest;
use App\Http\Requests\CarRetailer\CarRetailerUpdateRequest;
use App\Models\CarRetailer;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class CarRetailerService
{
    public function index(CarRetailerIndexRequest $request): LengthAwarePaginator
    {
        return CarRetailer::select([
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

    public function changeStatus(CarRetailerChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('car_retailers');

        $carRetailer = CarRetailer::find($data['id']);

        if (!$carRetailer) {
            return response()->json([
                'message' => 'Car Retailer not found',
                'alert-type' => 'error'
            ], 404);
        }

        $carRetailer->update(['status' => $data['status']]);

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function show(CarRetailer $carRetailer): CarRetailer
    {
        return $carRetailer;
    }

    public function edit(CarRetailer $carRetailer): CarRetailer
    {
        return $carRetailer;
    }

    public function update(CarRetailerUpdateRequest $request, CarRetailer $carRetailer): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('car_retailers');
        
        $carRetailer->update($data);
        $carRetailer->fresh();

        return response()->json([
            'carRetailer' => $carRetailer,
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(CarRetailerDestroyRequest $request): JsonResponse
    {
        Cache::forget('car_retailers');
        $carRetailer = CarRetailer::find($request->id);
        
        if (!$carRetailer) {
            return response()->json([
                'message' => 'Car Retailer not found',
                'alert-type' => 'error'
            ], 404);
        }
        
        $carRetailer->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(CarRetailerMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('car_retailers');
        CarRetailer::whereIn('id', $request->ids)->delete();
        
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function trash(CarRetailerTrashRequest $request): LengthAwarePaginator
    {
        return CarRetailer::select(['id', 'legal_business_name', 'contact_name', 'contact_email', 'created_at'])
            ->filterTrash($request)
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function restore(CarRetailerRestoreRequest $request): JsonResponse
    {
        Cache::forget('car_retailers');
        $carRetailer = CarRetailer::where('id', $request->id)->withTrashed()->first();
        
        if (!$carRetailer) {
            return response()->json([
                'message' => 'Car Retailer not found',
                'alert-type' => 'error'
            ], 404);
        }
        
        $carRetailer->restore();
        $carRetailer->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function remove(CarRetailerRemoveRequest $request): JsonResponse
    {
        Cache::forget('car_retailers');
        $carRetailerId = $request->id;
        $carRetailer = CarRetailer::where('id', $carRetailerId)->withTrashed()->first();
        
        if (!$carRetailer) {
            return response()->json([
                'message' => 'Car Retailer not found',
                'alert-type' => 'error'
            ], 404);
        }
        
        $carRetailer->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function massRemove(CarRetailerMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('car_retailers');

        CarRetailer::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Get all car retailers for export.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function export()
    {
        return CarRetailer::select([
            'id',
            'legal_business_name',
            'dba',
            'business_type',
            'platform_type',
            'years_operation',
            'website_url',
            'contact_name',
            'contact_title',
            'contact_phone',
            'contact_email',
            'fulfillment_address',
            'multiple_warehouses',
            'shipping_nodes',
            'inventory_api_access',
            'api_url_docs',
            'vehicle_list',
            'cars_shipped',
            'vehicle_types',
            'transport_type',
            'preferred_delivery',
            'unattended_pickup',
            'billing_contact',
            'billing_email',
            'payment_method',
            'vendor_platforms',
            'ein_tax_id',
            'w9_upload',
            'insurance_certificate',
            'nda_required',
            'trade_references',
            'status',
            'admin_notes',
            'created_at',
            'updated_at'
        ])->orderBy('created_at', 'desc')->get();
    }
}
