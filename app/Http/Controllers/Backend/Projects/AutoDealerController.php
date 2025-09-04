<?php

namespace App\Http\Controllers\Backend\Projects;

use App\Http\Requests\AutoDealer\AutoDealerChangeStatusRequest;
use App\Http\Requests\AutoDealer\AutoDealerDestroyRequest;
use App\Http\Requests\AutoDealer\AutoDealerIndexRequest;
use App\Http\Requests\AutoDealer\AutoDealerMassDestroyRequest;
use App\Http\Requests\AutoDealer\AutoDealerMassRemoveRequest;
use App\Http\Requests\AutoDealer\AutoDealerRemoveRequest;
use App\Http\Requests\AutoDealer\AutoDealerRestoreRequest;
use App\Http\Requests\AutoDealer\AutoDealerTrashRequest;
use App\Http\Requests\AutoDealer\AutoDealerUpdateRequest;
use App\Services\AutoDealerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\AutoDealer;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AutoDealerController extends Controller
{
    private AutoDealerService $autoDealerService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(AutoDealerService $autoDealerService)
    {
        $this->autoDealerService = $autoDealerService;
    }

    /**
     * Display a listing of the auto dealers.
     */
    public function index(AutoDealerIndexRequest $request): View
    {
        return view('backend.autoDealers.index', [
            'autoDealers' => $this->autoDealerService->index($request)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param AutoDealer $autoDealer
     * @return View
     */
    public function show(AutoDealer $autoDealer): View
    {
        return view('backend.autoDealers.show', compact('autoDealer'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AutoDealerDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(AutoDealerDestroyRequest $request): JsonResponse
    {
        try {
            return $this->autoDealerService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Auto Dealer: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass destroy the specified resources from storage.
     *
     * @param AutoDealerMassDestroyRequest $request
     * @return JsonResponse
     */
    public function massDestroy(AutoDealerMassDestroyRequest $request): JsonResponse
    {
        try {
            $this->autoDealerService->massDestroy($request);
            return response()->json([
                'message' => __('strings.Deleted Successfully')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting Auto Dealers: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export auto dealers to Excel.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $autoDealers = $this->autoDealerService->export();

        $filename = 'auto_dealers_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($autoDealers) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, [
                'ID',
                'Legal Business Name',
                'DBA',
                'Business Type',
                'Years Operation',
                'Website URL',
                'Contact Name',
                'Contact Title',
                'Contact Phone',
                'Contact Email',
                'Main Address',
                'Multiple Locations',
                'Additional Addresses',
                'Dealer License',
                'Federal Tax ID',
                'DUNS Number',
                'Cars Per Month',
                'Vehicle Types',
                'Transport Preference',
                'Delivery Type',
                'Inventory Contact',
                'Pickup Times',
                'Delivery Days',
                'Billing Contact',
                'Billing Email',
                'Payment Method',
                'Vendor Platforms',
                'NDA Required',
                'Trade Reference',
                'W9 Upload',
                'Insurance Certificate',
                'Status',
                'Admin Notes',
                'Created At',
                'Updated At'
            ]);

            // Add data rows
            foreach ($autoDealers as $autoDealer) {
                fputcsv($file, [
                    $autoDealer->id,
                    $autoDealer->legal_business_name,
                    $autoDealer->dba,
                    $autoDealer->business_type,
                    $autoDealer->years_operation,
                    $autoDealer->website_url,
                    $autoDealer->contact_name,
                    $autoDealer->contact_title,
                    $autoDealer->contact_phone,
                    $autoDealer->contact_email,
                    $autoDealer->main_address,
                    $autoDealer->multiple_locations,
                    $autoDealer->additional_addresses,
                    $autoDealer->dealer_license,
                    $autoDealer->federal_tax_id,
                    $autoDealer->duns_number,
                    $autoDealer->cars_per_month,
                    is_array($autoDealer->vehicle_types) ? implode(', ', $autoDealer->vehicle_types) : $autoDealer->vehicle_types,
                    $autoDealer->transport_preference,
                    $autoDealer->delivery_type,
                    $autoDealer->inventory_contact,
                    $autoDealer->pickup_times,
                    $autoDealer->delivery_days,
                    $autoDealer->billing_contact,
                    $autoDealer->billing_email,
                    is_array($autoDealer->payment_method) ? implode(', ', $autoDealer->payment_method) : $autoDealer->payment_method,
                    $autoDealer->vendor_platforms,
                    $autoDealer->nda_required,
                    $autoDealer->trade_reference,
                    $autoDealer->w9_upload,
                    $autoDealer->insurance_certificate,
                    $autoDealer->status,
                    $autoDealer->admin_notes,
                    $autoDealer->created_at ? $autoDealer->created_at->format('Y-m-d H:i:s') : '',
                    $autoDealer->updated_at ? $autoDealer->updated_at->format('Y-m-d H:i:s') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
