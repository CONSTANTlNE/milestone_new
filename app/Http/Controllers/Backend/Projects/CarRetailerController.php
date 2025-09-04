<?php

namespace App\Http\Controllers\Backend\Projects;

use App\Http\Requests\CarRetailer\CarRetailerChangeStatusRequest;
use App\Http\Requests\CarRetailer\CarRetailerDestroyRequest;
use App\Http\Requests\CarRetailer\CarRetailerIndexRequest;
use App\Http\Requests\CarRetailer\CarRetailerMassDestroyRequest;
use App\Http\Requests\CarRetailer\CarRetailerMassRemoveRequest;
use App\Http\Requests\CarRetailer\CarRetailerRemoveRequest;
use App\Http\Requests\CarRetailer\CarRetailerRestoreRequest;
use App\Http\Requests\CarRetailer\CarRetailerTrashRequest;
use App\Http\Requests\CarRetailer\CarRetailerUpdateRequest;
use App\Services\CarRetailerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\CarRetailer;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CarRetailerController extends Controller
{
    private CarRetailerService $carRetailerService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(CarRetailerService $carRetailerService)
    {
        $this->carRetailerService = $carRetailerService;
    }

    /**
     * Display a listing of the car retailers.
     */
    public function index(CarRetailerIndexRequest $request): View
    {
        return view('backend.carRetailers.index', [
            'carRetailers' => $this->carRetailerService->index($request)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $carRetailer = CarRetailer::findOrFail($id);
        return view('backend.carRetailers.show', compact('carRetailer'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CarRetailerDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(CarRetailerDestroyRequest $request): JsonResponse
    {
        try {
            return $this->carRetailerService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Car Retailer: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass destroy the specified resources from storage.
     *
     * @param CarRetailerMassDestroyRequest $request
     * @return JsonResponse
     */
    public function massDestroy(CarRetailerMassDestroyRequest $request): JsonResponse
    {
        try {
            $this->carRetailerService->massDestroy($request);
            return response()->json([
                'message' => __('strings.Deleted Successfully')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting Car Retailers: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export car retailers to Excel.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $carRetailers = $this->carRetailerService->export();

        $filename = 'car_retailers_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($carRetailers) {
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
                'Fulfillment Address',
                'Multiple Warehouses',
                'Shipping Nodes',
                'Inventory API Access',
                'API URL Docs',
                'Vehicle List',
                'Cars Shipped',
                'Vehicle Types',
                'Transport Type',
                'Preferred Delivery',
                'Unattended Pickup',
                'Billing Contact',
                'Billing Email',
                'Payment Method',
                'Vendor Platforms',
                'EIN/Tax ID',
                'W9 Upload',
                'Insurance Certificate',
                'NDA Required',
                'Trade References',
                'Status',
                'Admin Notes',
                'Created At',
                'Updated At'
            ]);

            // Add data rows
            foreach ($carRetailers as $carRetailer) {
                fputcsv($file, [
                    $carRetailer->id,
                    $carRetailer->legal_business_name,
                    $carRetailer->dba,
                    $carRetailer->business_type,
                    is_array($carRetailer->platform_type) ? implode(', ', $carRetailer->platform_type) : $carRetailer->platform_type,
                    $carRetailer->years_operation,
                    $carRetailer->website_url,
                    $carRetailer->contact_name,
                    $carRetailer->contact_title,
                    $carRetailer->contact_phone,
                    $carRetailer->contact_email,
                    $carRetailer->fulfillment_address,
                    $carRetailer->multiple_warehouses,
                    $carRetailer->shipping_nodes,
                    $carRetailer->inventory_api_access,
                    $carRetailer->api_url_docs,
                    $carRetailer->vehicle_list,
                    $carRetailer->cars_shipped,
                    is_array($carRetailer->vehicle_types) ? implode(', ', $carRetailer->vehicle_types) : $carRetailer->vehicle_types,
                    $carRetailer->transport_type,
                    $carRetailer->preferred_delivery,
                    $carRetailer->unattended_pickup,
                    $carRetailer->billing_contact,
                    $carRetailer->billing_email,
                    is_array($carRetailer->payment_method) ? implode(', ', $carRetailer->payment_method) : $carRetailer->payment_method,
                    $carRetailer->vendor_platforms,
                    $carRetailer->ein_tax_id,
                    $carRetailer->w9_upload,
                    $carRetailer->insurance_certificate,
                    $carRetailer->nda_required,
                    $carRetailer->trade_references,
                    $carRetailer->status,
                    $carRetailer->admin_notes,
                    $carRetailer->created_at ? $carRetailer->created_at->format('Y-m-d H:i:s') : '',
                    $carRetailer->updated_at ? $carRetailer->updated_at->format('Y-m-d H:i:s') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
