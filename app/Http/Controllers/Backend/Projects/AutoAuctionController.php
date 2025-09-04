<?php

namespace App\Http\Controllers\Backend\Projects;

use App\Http\Requests\AutoAuction\AutoAuctionChangeStatusRequest;
use App\Http\Requests\AutoAuction\AutoAuctionDestroyRequest;
use App\Http\Requests\AutoAuction\AutoAuctionIndexRequest;
use App\Http\Requests\AutoAuction\AutoAuctionMassDestroyRequest;
use App\Http\Requests\AutoAuction\AutoAuctionMassRemoveRequest;
use App\Http\Requests\AutoAuction\AutoAuctionRemoveRequest;
use App\Http\Requests\AutoAuction\AutoAuctionRestoreRequest;
use App\Http\Requests\AutoAuction\AutoAuctionTrashRequest;
use App\Http\Requests\AutoAuction\AutoAuctionUpdateRequest;
use App\Services\AutoAuctionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\AutoAuction;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AutoAuctionController extends Controller
{
    private AutoAuctionService $autoAuctionService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(AutoAuctionService $autoAuctionService)
    {
        $this->autoAuctionService = $autoAuctionService;
    }

    /**
     * Display a listing of the auto auctions.
     */
    public function index(AutoAuctionIndexRequest $request): View
    {
        return view('backend.autoAuctions.index', [
            'autoAuctions' => $this->autoAuctionService->index($request)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param AutoAuction $autoAuction
     * @return View
     */
    public function show(AutoAuction $autoAuction): View
    {
        return view('backend.autoAuctions.show', compact('autoAuction'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AutoAuctionDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(AutoAuctionDestroyRequest $request): JsonResponse
    {
        try {
            return $this->autoAuctionService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Auto Auction: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass destroy the specified resources from storage.
     *
     * @param AutoAuctionMassDestroyRequest $request
     * @return JsonResponse
     */
    public function massDestroy(AutoAuctionMassDestroyRequest $request): JsonResponse
    {
        try {
            $this->autoAuctionService->massDestroy($request);
            return response()->json([
                'message' => __('strings.Deleted Successfully')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting Auto Auctions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export auto auctions to Excel.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $autoAuctions = $this->autoAuctionService->export();

        $filename = 'auto_auctions_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($autoAuctions) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, [
                'ID',
                'Legal Business Name',
                'DBA',
                'Business Type',
                'Platform Type',
                'Years Operation',
                'Website URL',
                'Contact Name',
                'Contact Title',
                'Contact Phone',
                'Contact Email',
                'Main Address',
                'Multiple Locations',
                'Additional Locations',
                'Primary Auction Days',
                'Lot Numbers',
                'Inventory System',
                'Unattended Pickup',
                'Vehicle List',
                'Vehicles Shipped',
                'Vehicle Types',
                'Transport Type',
                'Pickup Protocols',
                'Condition Reports',
                'Carrier Preloading',
                'Billing Contact',
                'Billing Email',
                'Payment Method',
                'Vendor Platforms',
                'EIN/Tax ID',
                'Dealer License',
                'W9 Upload',
                'Insurance Certificate',
                'Trade References',
                'Status',
                'Admin Notes',
                'Created At',
                'Updated At'
            ]);

            // Add data rows
            foreach ($autoAuctions as $autoAuction) {
                fputcsv($file, [
                    $autoAuction->id,
                    $autoAuction->legal_business_name,
                    $autoAuction->dba,
                    $autoAuction->business_type,
                    is_array($autoAuction->platform_type) ? implode(', ', $autoAuction->platform_type) : $autoAuction->platform_type,
                    $autoAuction->years_operation,
                    $autoAuction->website_url,
                    $autoAuction->contact_name,
                    $autoAuction->contact_title,
                    $autoAuction->contact_phone,
                    $autoAuction->contact_email,
                    $autoAuction->main_address,
                    $autoAuction->multiple_locations,
                    $autoAuction->additional_locations,
                    $autoAuction->primary_auction_days,
                    $autoAuction->lot_numbers,
                    $autoAuction->inventory_system,
                    $autoAuction->unattended_pickup,
                    $autoAuction->vehicle_list,
                    $autoAuction->vehicles_shipped,
                    is_array($autoAuction->vehicle_types) ? implode(', ', $autoAuction->vehicle_types) : $autoAuction->vehicle_types,
                    $autoAuction->transport_type,
                    $autoAuction->pickup_protocols,
                    $autoAuction->condition_reports,
                    $autoAuction->carrier_preloading,
                    $autoAuction->billing_contact,
                    $autoAuction->billing_email,
                    is_array($autoAuction->payment_method) ? implode(', ', $autoAuction->payment_method) : $autoAuction->payment_method,
                    $autoAuction->vendor_platforms,
                    $autoAuction->ein_tax_id,
                    $autoAuction->dealer_license,
                    $autoAuction->w9_upload,
                    $autoAuction->insurance_certificate,
                    $autoAuction->trade_references,
                    $autoAuction->status,
                    $autoAuction->admin_notes,
                    $autoAuction->created_at ? $autoAuction->created_at->format('Y-m-d H:i:s') : '',
                    $autoAuction->updated_at ? $autoAuction->updated_at->format('Y-m-d H:i:s') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
