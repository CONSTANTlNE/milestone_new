<?php

namespace App\Services;

use App\Http\Requests\AutoDealer\AutoDealerChangeStatusRequest;
use App\Http\Requests\AutoDealer\AutoDealerDestroyRequest;
use App\Http\Requests\AutoDealer\AutoDealerIndexRequest;
use App\Http\Requests\AutoDealer\AutoDealerMassDestroyRequest;
use App\Http\Requests\AutoDealer\AutoDealerMassRemoveRequest;
use App\Http\Requests\AutoDealer\AutoDealerRemoveRequest;
use App\Http\Requests\AutoDealer\AutoDealerRestoreRequest;
use App\Http\Requests\AutoDealer\AutoDealerTrashRequest;
use App\Http\Requests\AutoDealer\AutoDealerUpdateRequest;
use App\Models\AutoDealer;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class AutoDealerService
{
    public function index(AutoDealerIndexRequest $request): LengthAwarePaginator
    {
        return AutoDealer::select([
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

    public function changeStatus(AutoDealerChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('auto_dealers');

        $autoDealer = AutoDealer::find($data['id']);

        if (!$autoDealer) {
            return response()->json([
                'message' => 'Auto Dealer not found',
                'alert-type' => 'error'
            ], 404);
        }

        $autoDealer->update(['status' => $data['status']]);

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function show(AutoDealer $autoDealer): AutoDealer
    {
        return $autoDealer;
    }

    public function edit(AutoDealer $autoDealer): AutoDealer
    {
        return $autoDealer;
    }

    public function update(AutoDealerUpdateRequest $request, AutoDealer $autoDealer): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('auto_dealers');
        
        $autoDealer->update($data);
        $autoDealer->fresh();

        return response()->json([
            'autoDealer' => $autoDealer,
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(AutoDealerDestroyRequest $request): JsonResponse
    {
        Cache::forget('auto_dealers');
        $autoDealer = AutoDealer::find($request->id);
        
        if (!$autoDealer) {
            return response()->json([
                'message' => 'Auto Dealer not found',
                'alert-type' => 'error'
            ], 404);
        }
        
        $autoDealer->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(AutoDealerMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('auto_dealers');
        AutoDealer::whereIn('id', $request->ids)->delete();
        
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function trash(AutoDealerTrashRequest $request): LengthAwarePaginator
    {
        return AutoDealer::select(['id', 'legal_business_name', 'contact_name', 'contact_email', 'created_at'])
            ->filterTrash($request)
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function restore(AutoDealerRestoreRequest $request): JsonResponse
    {
        Cache::forget('auto_dealers');
        $autoDealer = AutoDealer::where('id', $request->id)->withTrashed()->first();
        
        if (!$autoDealer) {
            return response()->json([
                'message' => 'Auto Dealer not found',
                'alert-type' => 'error'
            ], 404);
        }
        
        $autoDealer->restore();
        $autoDealer->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function remove(AutoDealerRemoveRequest $request): JsonResponse
    {
        Cache::forget('auto_dealers');
        $autoDealerId = $request->id;
        $autoDealer = AutoDealer::where('id', $autoDealerId)->withTrashed()->first();
        
        if (!$autoDealer) {
            return response()->json([
                'message' => 'Auto Dealer not found',
                'alert-type' => 'error'
            ], 404);
        }
        
        $autoDealer->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function massRemove(AutoDealerMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('auto_dealers');

        AutoDealer::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Export auto dealers to CSV.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function export(): \Illuminate\Database\Eloquent\Collection
    {
        return AutoDealer::select([
            'id',
            'legal_business_name',
            'dba',
            'business_type',
            'years_operation',
            'website_url',
            'contact_name',
            'contact_title',
            'contact_phone',
            'contact_email',
            'main_address',
            'multiple_locations',
            'additional_addresses',
            'dealer_license',
            'federal_tax_id',
            'duns_number',
            'cars_per_month',
            'vehicle_types',
            'transport_preference',
            'delivery_type',
            'inventory_contact',
            'pickup_times',
            'delivery_days',
            'billing_contact',
            'billing_email',
            'payment_method',
            'vendor_platforms',
            'nda_required',
            'trade_reference',
            'w9_upload',
            'insurance_certificate',
            'status',
            'admin_notes',
            'created_at',
            'updated_at'
        ])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
