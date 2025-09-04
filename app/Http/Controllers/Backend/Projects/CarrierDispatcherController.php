<?php

namespace App\Http\Controllers\Backend\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherChangeStatusRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherDestroyRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherIndexRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherMassDestroyRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherMassRemoveRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherRemoveRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherRestoreRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherTrashRequest;
use App\Http\Requests\CarrierDispatcher\CarrierDispatcherUpdateRequest;
use App\Services\CarrierDispatcherService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\CarrierDispatcher;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class CarrierDispatcherController extends Controller
{
    private CarrierDispatcherService $carrierDispatcherService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(CarrierDispatcherService $carrierDispatcherService)
    {
        $this->carrierDispatcherService = $carrierDispatcherService;
    }

    /**
     * Display a listing of the carrier dispatchers.
     */
    public function index(CarrierDispatcherIndexRequest $request): View
    {
        return view('backend.carrierDispatchers.index', [
            'carrierDispatchers' => $this->carrierDispatcherService->index($request)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param CarrierDispatcher $carrierDispatcher
     * @return View
     */
    public function show(CarrierDispatcher $carrierDispatcher): View
    {
        return view('backend.carrierDispatchers.show', compact('carrierDispatcher'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CarrierDispatcherDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(CarrierDispatcherDestroyRequest $request): JsonResponse
    {
        try {
            return $this->carrierDispatcherService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Carrier Dispatcher: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass destroy the specified resources from storage.
     *
     * @param CarrierDispatcherMassDestroyRequest $request
     * @return JsonResponse
     */
    public function massDestroy(CarrierDispatcherMassDestroyRequest $request): JsonResponse
    {
        try {
            $this->carrierDispatcherService->massDestroy($request);
            return response()->json([
                'message' => __('strings.Deleted Successfully')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting Carrier Dispatchers: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export carrier dispatchers to Excel.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $carrierDispatchers = $this->carrierDispatcherService->export();

        $filename = 'carrier_dispatchers_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($carrierDispatchers) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, [
                'ID',
                'MC Number',
                'DOT Number',
                'Cars Under Management',
                'Website URL',
                'Legal Business Name',
                'DBA',
                'Business Type',
                'Years Operation',
                'Contact Name',
                'Contact Title',
                'Contact Phone',
                'Contact Email',
                'Main Address',
                'Multiple Locations',
                'Additional Addresses',
                'Billing Contact',
                'Billing Email',
                'Payment Method',
                'NDA Required',
                'W9 Upload',
                'Insurance Certificate',
                'Presentation File',
                'Vehicle List File',
                'Status',
                'Admin Notes',
                'Created At',
                'Updated At'
            ]);

            // Add data rows
            foreach ($carrierDispatchers as $carrierDispatcher) {
                fputcsv($file, [
                    $carrierDispatcher->id,
                    $carrierDispatcher->mc_number,
                    $carrierDispatcher->dot_number,
                    $carrierDispatcher->cars_under_management,
                    $carrierDispatcher->website_url,
                    $carrierDispatcher->legal_business_name,
                    $carrierDispatcher->dba,
                    $carrierDispatcher->business_type,
                    $carrierDispatcher->years_operation,
                    $carrierDispatcher->contact_name,
                    $carrierDispatcher->contact_title,
                    $carrierDispatcher->contact_phone,
                    $carrierDispatcher->contact_email,
                    $carrierDispatcher->main_address,
                    $carrierDispatcher->multiple_locations,
                    $carrierDispatcher->additional_addresses,
                    $carrierDispatcher->billing_contact,
                    $carrierDispatcher->billing_email,
                    is_array($carrierDispatcher->payment_method) ? implode(', ', $carrierDispatcher->payment_method) : $carrierDispatcher->payment_method,
                    $carrierDispatcher->nda_required,
                    $carrierDispatcher->w9_upload,
                    $carrierDispatcher->insurance_certificate,
                    $carrierDispatcher->presentation_file,
                    $carrierDispatcher->vehicle_list_file,
                    $carrierDispatcher->status,
                    $carrierDispatcher->admin_notes,
                    $carrierDispatcher->created_at ? $carrierDispatcher->created_at->format('Y-m-d H:i:s') : '',
                    $carrierDispatcher->updated_at ? $carrierDispatcher->updated_at->format('Y-m-d H:i:s') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download a file.
     */
    public function downloadFile(CarrierDispatcher $carrierDispatcher, $fileType)
    {
        $filePath = null;
        $fileName = '';

        switch ($fileType) {
            case 'presentation':
                $filePath = $carrierDispatcher->presentation_file;
                $fileName = 'presentation_' . $carrierDispatcher->id . '.pdf';
                break;
            case 'vehicle_list':
                $filePath = $carrierDispatcher->vehicle_list_file;
                $fileName = 'vehicle_list_' . $carrierDispatcher->id . '.pdf';
                break;
            case 'w9':
                $filePath = $carrierDispatcher->w9_upload;
                $fileName = 'w9_' . $carrierDispatcher->id . '.pdf';
                break;
            case 'insurance':
                $filePath = $carrierDispatcher->insurance_certificate;
                $fileName = 'insurance_' . $carrierDispatcher->id . '.pdf';
                break;
            default:
                abort(404);
        }

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        return Storage::disk('public')->download($filePath, $fileName);
    }
}
