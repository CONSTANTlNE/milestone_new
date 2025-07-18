<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\PermissionsDataTableTrash;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\Page\PageChangeStatusRequest;
use App\Http\Requests\Permission\PermissionChangeStatusRequest;
use App\Http\Requests\Permission\PermissionCreateRequest;
use App\Http\Requests\Permission\PermissionDestroyRequest;
use App\Http\Requests\Permission\PermissionIndexRequest;
use App\Http\Requests\Permission\PermissionMassDestroyRequest;
use App\Http\Requests\Permission\PermissionMassRemoveRequest;
use App\Http\Requests\Permission\PermissionRemoveRequest;
use App\Http\Requests\Permission\PermissionRestoreRequest;
use App\Http\Requests\Permission\PermissionTrashRequest;
use App\Http\Requests\Permission\PermissionUpdateRequest;
use App\Services\PermissionService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PermissionController extends Controller
{
    private PermissionService $permissionService;

    /**
     * Create the controller instance.
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the permissions.
     */
    public function index(PermissionIndexRequest $request): View
    {
        $this->authorize('viewAny', Permission::class);

        return view('backend.permissions.index', [
            'permissions' => $this->permissionService->index($request)
        ]);
    }

    /**
     * Change Status.
     *
     * @param PermissionChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(PermissionChangeStatusRequest $request): JsonResponse
    {
        try {
            return $this->permissionService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status permission: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Show the form for creating a new permission.
     */
    public function create(): View
    {
        $this->authorize('create', Permission::class);
        return view('backend.permissions.create', [
            'routes' => $this->permissionService->getAllRoutes()
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionCreateRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function store(PermissionCreateRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('create', Permission::class);
        try {
            $this->permissionService->store($request);
            return redirect()->route('backend.permissions.index')
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating permission: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param Permission $permission
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function show(Permission $permission): JsonResponse|View
    {
        $this->authorize('view', $permission);

        try {
            return view('backend.permissions.show', [
                'permission' => $this->permissionService->show($permission)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the permission: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param Permission $permission
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function edit(Permission $permission): JsonResponse|View
    {
        $this->authorize('update', $permission);

        try {
            return view('backend.permissions.edit', [
                'permission' => $this->permissionService->edit($permission),
                'routes' => $this->permissionService->getAllRoutes()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the permission: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param PermissionUpdateRequest $request
     * @param Permission $permission
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(PermissionUpdateRequest $request, Permission $permission): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $permission);

        try {
            $this->permissionService->update($request, $permission);
            return redirect()->route('backend.permissions.index')
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating Permission: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft Delete Permission.
     * @param PermissionDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(PermissionDestroyRequest $request): JsonResponse
    {
        try {
            return $this->permissionService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting permission: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass delete permissions.
     */

    public function massDestroy(PermissionMassDestroyRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('viewAny', Permission::class);


        return $this->executeOperation(function () use ($request) {
            $this->permissionService->massDestroy($request);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => __('strings.Deleted Successfully')
                ], 200);
            }

            return redirect()->route('backend.permissions.index')
                ->with('success', __('strings.Deleted Successfully'));
        }, 'Permission Mass Deletion');
    }

    // Archive
    /**
     * View all Permissions in Trash.
     *
     * @param PermissionTrashRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function trash(PermissionTrashRequest $request): View
    {
        $this->authorize('trash', Permission::class);

        return view('backend.permissions.trash', [
            'permissions' => $this->permissionService->trash($request)
        ]);
    }

    /**
     * Restore a soft deleted permission.
     *
     * @param PermissionRestoreRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(PermissionRestoreRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('restore', Permission::class);

        try {
            return $this->permissionService->restore($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring Permission: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource permanently.
     *
     * @param PermissionRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function remove(PermissionRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Permission::class);
        try {
            return $this->permissionService->remove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing Permission: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Mass permanently delete permissions from trash.
     */
    /**
     * Mass remove the specified resources permanently.
     *
     * @param PermissionMassRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function massRemove(PermissionMassRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Permission::class);
        try {
            return $this->permissionService->massRemove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass removing permission: ' . $e->getMessage()
            ], 500);
        }
    }
}
