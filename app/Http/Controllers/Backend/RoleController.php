<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Role\RoleChangeStatusRequest;
use App\Http\Requests\Role\RoleCreateRequest;
use App\Http\Requests\Role\RoleDestroyRequest;
use App\Http\Requests\Role\RoleIndexRequest;
use App\Http\Requests\Role\RoleMassDestroyRequest;
use App\Http\Requests\Role\RoleMassRemoveRequest;
use App\Http\Requests\Role\RoleRemoveRequest;
use App\Http\Requests\Role\RoleRestoreRequest;
use App\Http\Requests\Role\RoleTrashRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Services\RoleService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class RoleController extends Controller
{
    private RoleService $roleService;

    /**
     * Create the controller instance.
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the roles.
     */
    public function index(RoleIndexRequest $request): View
    {
        $this->authorize('viewAny', Role::class);

        return view('backend.roles.index', [
            'roles' => $this->roleService->index($request)
        ]);
    }

    /**
     * Change Status.
     *
     * @param RoleChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(RoleChangeStatusRequest $request): JsonResponse
    {
        try {
            return $this->roleService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status Role: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        $this->authorize('create', Role::class);
        return view('backend.roles.create', [
            'permissions' => $this->roleService->getPermission()
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param RoleCreateRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function store(RoleCreateRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('create', Role::class);
        try {
            $this->roleService->store($request);
            return redirect()->route('backend.roles.index')
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating Role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function show(Role $role): JsonResponse|View
    {
        $this->authorize('view', $role);

        try {
            return view('backend.roles.show', [
                'role' => $this->roleService->show($role),
                'rolePermissions' => $this->roleService->getRolePermission($role)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the role: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Edit the specified resource.
     *
     * @param Role $role
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function edit(Role $role): JsonResponse|View
    {
        $this->authorize('update', $role);

        try {
            return view('backend.roles.edit', [
                'role' => $this->roleService->edit($role),
                'permissions' => $this->roleService->getPermission(),
                'rolePermissions' => $this->roleService->getRoleAllPermission($role)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the Role: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource.
     *
     * @param RoleUpdateRequest $request
     * @param Role $role
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(RoleUpdateRequest $request, Role $role): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $role);

        try {
            $this->roleService->update($request, $role);
            return redirect()->route('backend.roles.index')
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating Role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft Delete Role.
     * @param RoleDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(RoleDestroyRequest $request): JsonResponse
    {
        try {
            return $this->roleService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass delete roles.
     */

    public function massDestroy(RoleMassDestroyRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('viewAny', Role::class);


        return $this->executeOperation(function () use ($request) {
            $this->roleService->massDestroy($request);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => __('strings.Deleted Successfully')
                ], 200);
            }

            return redirect()->route('backend.roles.index')
                ->with('success', __('strings.Deleted Successfully'));
        }, 'Role Mass Deletion');
    }

    // Archive
    /**
     * View all Roles in Trash.
     *
     * @param RoleTrashRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function trash(RoleTrashRequest $request): View
    {
        $this->authorize('trash', Role::class);

        return view('backend.roles.trash', [
            'roles' => $this->roleService->trash($request)
        ]);
    }

    /**
     * Restore a soft deleted role.
     *
     * @param RoleRestoreRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(RoleRestoreRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('restore', Role::class);

        try {
            return $this->roleService->restore($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring Role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource permanently.
     *
     * @param RoleRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function remove(RoleRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Role::class);
        try {
            return $this->roleService->remove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing Role: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Mass permanently delete Roles from trash.
     */
    /**
     * Mass remove the specified resources permanently.
     *
     * @param RoleMassRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function massRemove(RoleMassRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Role::class);
        try {
            return $this->roleService->massRemove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass removing Role: ' . $e->getMessage()
            ], 500);
        }
    }
}
