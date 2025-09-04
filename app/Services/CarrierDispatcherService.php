<?php

namespace App\Services;

use App\Http\Requests\CarrierDispatcher\CarrierDispatcherChangeStatusRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherDestroyRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherIndexRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherMassDestroyRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherMassRemoveRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherRemoveRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherRestoreRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherTrashRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherUpdateRequest;
use App\Models\CarrierDispatcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class CarrierDispatcherService
{
    public function index(CarrierDispatcherIndexRequest $request): LengthAwarePaginator
    {
        return CarrierDispatcher::select([
            'id',
            'legal_business_name',
            'contact_name',
            'contact_email',
            'contact_phone',
            'business_type',
            'years_operation',
            'status',
            'created_at',
            'dba',
            'contact_title',
            'presentation_file',
            'vehicle_list_file',
            'w9_upload',
            'insurance_certificate'
        ])
            ->filter($request)
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function changeStatus(CarrierDispatcherChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('carrier_dispatchers');

        $carrierDispatcher = CarrierDispatcher::find($data['id']);

        if (!$carrierDispatcher) {
            return response()->json([
                'message' => 'Carrier Dispatcher not found',
                'alert-type' => 'error'
            ], 404);
        }

        $carrierDispatcher->update(['status' => $data['status']]);

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function show(CarrierDispatcher $carrierDispatcher): CarrierDispatcher
    {
        return $carrierDispatcher;
    }

    public function edit(CarrierDispatcher $carrierDispatcher): CarrierDispatcher
    {
        return $carrierDispatcher;
    }

    public function update(CarrierDispatcherUpdateRequest $request, CarrierDispatcher $carrierDispatcher): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('carrier_dispatchers');

        $carrierDispatcher->update($data);
        $carrierDispatcher->fresh();

        return response()->json([
            'carrierDispatcher' => $carrierDispatcher,
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(CarrierDispatcherDestroyRequest $request): JsonResponse
    {
        Cache::forget('carrier_dispatchers');
        $carrierDispatcher = CarrierDispatcher::find($request->id);

        if (!$carrierDispatcher) {
            return response()->json([
                'message' => 'Carrier Dispatcher not found',
                'alert-type' => 'error'
            ], 404);
        }

        $carrierDispatcher->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(CarrierDispatcherMassDestroyRequest $request): JsonResponse
    {
        try {
            Cache::forget('carrier_dispatchers');
            CarrierDispatcher::whereIn('id', $request->ids)->delete();
            return response()->json([
                'message' => __('strings.massDestroy Successfully')
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to mass delete: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    public function export(): Collection
    {
        return CarrierDispatcher::select([
            'id',
            'mc_number',
            'dot_number',
            'cars_under_management',
            'website_url',
            'legal_business_name',
            'dba',
            'business_type',
            'years_operation',
            'contact_name',
            'contact_title',
            'contact_phone',
            'contact_email',
            'main_address',
            'multiple_locations',
            'additional_addresses',
            'billing_contact',
            'billing_email',
            'payment_method',
            'nda_required',
            'w9_upload',
            'insurance_certificate',
            'presentation_file',
            'vehicle_list_file',
            'status',
            'admin_notes',
            'created_at',
            'updated_at'
        ])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
