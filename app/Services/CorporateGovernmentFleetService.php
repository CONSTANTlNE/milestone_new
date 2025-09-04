<?php

namespace App\Services;

use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetChangeStatusRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetDestroyRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetIndexRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetMassDestroyRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetMassRemoveRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetRemoveRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetRestoreRequest;
use App\Http\Requests\CorporateGovernmentFleet\CorporateGovernmentFleetUpdateRequest;
use App\Models\CorporateGovernmentFleet;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class CorporateGovernmentFleetService
{
    /**
     * Get paginated corporate government fleets.
     *
     * @param CorporateGovernmentFleetIndexRequest $request
     * @return LengthAwarePaginator
     */
    public function index(CorporateGovernmentFleetIndexRequest $request): LengthAwarePaginator
    {
        $query = CorporateGovernmentFleet::query();

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('legal_organization_name', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%")
                  ->orWhere('contact_email', 'like', "%{$search}%")
                  ->orWhere('contact_phone', 'like', "%{$search}%")
                  ->orWhere('business_type', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Apply business type filter
        if ($request->filled('business_type')) {
            $query->where('business_type', $request->get('business_type'));
        }

        // Apply sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        return $query->paginate($request->get('per_page', 25));
    }

    /**
     * Change status of corporate government fleet.
     *
     * @param CorporateGovernmentFleetChangeStatusRequest $request
     * @return JsonResponse
     */
    public function changeStatus(CorporateGovernmentFleetChangeStatusRequest $request): JsonResponse
    {
        $corporateGovernmentFleet = CorporateGovernmentFleet::findOrFail($request->get('id'));
        $corporateGovernmentFleet->update(['status' => $request->get('status')]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $corporateGovernmentFleet->status
        ]);
    }

    /**
     * Update corporate government fleet.
     *
     * @param CorporateGovernmentFleetUpdateRequest $request
     * @param CorporateGovernmentFleet $corporateGovernmentFleet
     * @return void
     */
    public function update(CorporateGovernmentFleetUpdateRequest $request, CorporateGovernmentFleet $corporateGovernmentFleet): void
    {
        $corporateGovernmentFleet->update($request->validated());
    }

    /**
     * Soft delete corporate government fleet.
     *
     * @param CorporateGovernmentFleetDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(CorporateGovernmentFleetDestroyRequest $request): JsonResponse
    {
        $corporateGovernmentFleet = CorporateGovernmentFleet::findOrFail($request->get('id'));
        $corporateGovernmentFleet->delete();

        return response()->json([
            'success' => true,
            'message' => 'Corporate/Government Fleet deleted successfully.'
        ]);
    }

    /**
     * Mass soft delete corporate government fleets.
     *
     * @param CorporateGovernmentFleetMassDestroyRequest $request
     * @return JsonResponse
     */
    public function massDestroy(CorporateGovernmentFleetMassDestroyRequest $request): JsonResponse
    {
        $ids = $request->get('ids', []);
        CorporateGovernmentFleet::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($ids) . ' Corporate/Government Fleet(s) deleted successfully.'
        ]);
    }

    /**
     * Get trashed corporate government fleets.
     *
     * @param CorporateGovernmentFleetTrashRequest $request
     * @return LengthAwarePaginator
     */
    public function trash(CorporateGovernmentFleetTrashRequest $request): LengthAwarePaginator
    {
        $query = CorporateGovernmentFleet::onlyTrashed();

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('legal_organization_name', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%")
                  ->orWhere('contact_email', 'like', "%{$search}%")
                  ->orWhere('contact_phone', 'like', "%{$search}%")
                  ->orWhere('business_type', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortField = $request->get('sort', 'deleted_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        return $query->paginate($request->get('per_page', 25));
    }

    /**
     * Restore corporate government fleet.
     *
     * @param CorporateGovernmentFleetRestoreRequest $request
     * @return JsonResponse
     */
    public function restore(CorporateGovernmentFleetRestoreRequest $request): JsonResponse
    {
        $corporateGovernmentFleet = CorporateGovernmentFleet::onlyTrashed()->findOrFail($request->get('id'));
        $corporateGovernmentFleet->restore();

        return response()->json([
            'success' => true,
            'message' => 'Corporate/Government Fleet restored successfully.'
        ]);
    }

    /**
     * Permanently delete corporate government fleet.
     *
     * @param CorporateGovernmentFleetRemoveRequest $request
     * @return JsonResponse
     */
    public function remove(CorporateGovernmentFleetRemoveRequest $request): JsonResponse
    {
        $corporateGovernmentFleet = CorporateGovernmentFleet::onlyTrashed()->findOrFail($request->get('id'));
        $corporateGovernmentFleet->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Corporate/Government Fleet permanently deleted.'
        ]);
    }

    /**
     * Mass permanently delete corporate government fleets.
     *
     * @param CorporateGovernmentFleetMassRemoveRequest $request
     * @return JsonResponse
     */
    public function massRemove(CorporateGovernmentFleetMassRemoveRequest $request): JsonResponse
    {
        $ids = $request->get('ids', []);
        CorporateGovernmentFleet::onlyTrashed()->whereIn('id', $ids)->forceDelete();

        return response()->json([
            'success' => true,
            'message' => count($ids) . ' Corporate/Government Fleet(s) permanently deleted.'
        ]);
    }
}
