<?php

namespace App\Http\Controllers\Backend;

use App\Contracts\PartnerInterface;
use App\DataTables\PartnersDataTable;
use App\DataTables\PartnersDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\Partner\PartnerCreateRequest;
use App\Http\Requests\Partner\PartnerUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Services\PartnerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Partner;
use Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class PartnerController extends Controller
{
    private PartnerService $partnerService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
        $this->authorizeResource(Partner::class, 'partner');
    }
    /**
     * View all Partners.
     *
     * @param PartnersDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(PartnersDataTable $dataTable)
    {
        $this->authorize('viewAny', Partner::class);
        return $dataTable->render('backend.partners.index');
    }

    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',Partner::class);
        try {
            return $this->partnerService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status partner: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create view the specified resource.
     *
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create', Partner::class);
        return view('backend.partners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PartnerCreateRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(PartnerCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Partner::class);
        try {
            $this->partnerService->store($request);
            return redirect()->route('backend.partners.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating partner: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param Partner $partner
     * @return JsonResponse|View
     */
    public function show($lang, Partner $partner): JsonResponse|View
    {
        $this->authorize('view', $partner);
        try {
            return view('backend.partners.show', [
                'partner' => $this->partnerService->show($partner)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the partner: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param Partner $partner
     * @return JsonResponse|View
     */
    public function edit($lang, Partner $partner): JsonResponse|View
    {
        $this->authorize('update', $partner);
        try {
            return view('backend.partners.edit', [
                'partner' => $this->partnerService->edit($partner)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the partner: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param Partner $partner
     * @return JsonResponse|View
     */
    public function update($lang, PartnerUpdateRequest $request, Partner $partner): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $partner);
        try {
            $this->partnerService->update($request, $partner);
            return redirect()->route('backend.partners.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating partner: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Partner.
     * @param $lang
     * @param Partner $partner
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, Partner $partner): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $partner);
        try {
            $this->partnerService->destroy($partner);
            return redirect()->route('backend.partners.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting partner: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Partner.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', Partner::class);
        try {
            $this->partnerService->massDestroy($request);
            return redirect()->route('backend.partners.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting partner: ' . $e->getMessage()
            ], 500);
        }
    }

    public function position()
    {
        $this->authorize('position', Partner::class);
        return view('backend.partners.position', [
            'partners' => $this->partnerService->getPartnerPosition()
        ]);
    }
    public function reorder(Request $request)
    {
        return $this->partnerService->reorder($request);
    }

    // Archive

    /**
     * View all Partners in Trash.
     *
     * @param PartnersDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(PartnersDataTableTrash $dataTable)
    {
        $this->authorize('trash', Partner::class);
        return $dataTable->render('backend.partners.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Partner::class);
        try {
            $this->partnerService->restore($id);
            return redirect()->route('backend.partners.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring partner: ' . $e->getMessage()
            ], 500);
        }

    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Partner::class);
        try {
            $this->partnerService->remove($id);
            return redirect()->route('backend.partners.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing partner: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Partner::class);
        try {
            $this->partnerService->massRemove($request);
            return redirect()->route('backend.partners.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing partner: ' . $e->getMessage()
            ], 500);
        }
    }
}
