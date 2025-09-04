<?php

namespace App\Services;

use App\Http\Requests\AutoAuction\AutoAuctionChangeStatusRequest;
use App\Http\Requests\AutoAuction\AutoAuctionDestroyRequest;
use App\Http\Requests\AutoAuction\AutoAuctionIndexRequest;
use App\Http\Requests\AutoAuction\AutoAuctionMassDestroyRequest;
use App\Http\Requests\AutoAuction\AutoAuctionMassRemoveRequest;
use App\Http\Requests\AutoAuction\AutoAuctionRemoveRequest;
use App\Http\Requests\AutoAuction\AutoAuctionRestoreRequest;
use App\Http\Requests\AutoAuction\AutoAuctionTrashRequest;
use App\Http\Requests\AutoAuction\AutoAuctionUpdateRequest;
use App\Models\AutoAuction;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class AutoAuctionService
{
    public function index(AutoAuctionIndexRequest $request): LengthAwarePaginator
    {
        return AutoAuction::select([
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

    public function changeStatus(AutoAuctionChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('auto_auctions');

        $autoAuction = AutoAuction::find($data['id']);

        if (!$autoAuction) {
            return response()->json([
                'message' => 'Auto Auction not found',
                'alert-type' => 'error'
            ], 404);
        }

        $autoAuction->update(['status' => $data['status']]);

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function show(AutoAuction $autoAuction): AutoAuction
    {
        return $autoAuction;
    }

    public function edit(AutoAuction $autoAuction): AutoAuction
    {
        return $autoAuction;
    }

    public function update(AutoAuctionUpdateRequest $request, AutoAuction $autoAuction): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('auto_auctions');

        $autoAuction->update($data);
        $autoAuction->fresh();

        return response()->json([
            'autoAuction' => $autoAuction,
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(AutoAuctionDestroyRequest $request): JsonResponse
    {
        Cache::forget('auto_auctions');
        $autoAuction = AutoAuction::find($request->id);

        if (!$autoAuction) {
            return response()->json([
                'message' => 'Auto Auction not found',
                'alert-type' => 'error'
            ], 404);
        }

        $autoAuction->delete();

//        $autoAuction = AutoAuction::where('id', $request->id)->withTrashed()->first();
//
//        if (!$autoAuction) {
//            return response()->json([
//                'message' => 'Auto Auction not found',
//                'alert-type' => 'error'
//            ], 404);
//        }
//
//        $autoAuction->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(AutoAuctionMassDestroyRequest $request): JsonResponse
    {
        try {
            Cache::forget('auto_auctions');
            AutoAuction::whereIn('id', $request->ids)->delete();
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
        return AutoAuction::select([
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
            'main_address',
            'multiple_locations',
            'additional_locations',
            'primary_auction_days',
            'lot_numbers',
            'inventory_system',
            'unattended_pickup',
            'vehicle_list',
            'vehicles_shipped',
            'vehicle_types',
            'transport_type',
            'pickup_protocols',
            'condition_reports',
            'carrier_preloading',
            'billing_contact',
            'billing_email',
            'payment_method',
            'vendor_platforms',
            'ein_tax_id',
            'dealer_license',
            'w9_upload',
            'insurance_certificate',
            'trade_references',
            'status',
            'admin_notes',
            'created_at',
            'updated_at'
        ])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
