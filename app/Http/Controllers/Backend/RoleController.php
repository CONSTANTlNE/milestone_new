<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\RolesDataTable;
use App\DataTables\RolesDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\Role\RoleCreateRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Services\RoleService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class RoleController extends Controller
{
    private RoleService $roleService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
        $this->authorizeResource(Role::class, 'role');
    }
    /**
     * View all Roles.
     *
     * @param RolesDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(RolesDataTable $dataTable)
    {
        $this->authorize('viewAny', Role::class);
        return $dataTable->render('backend.roles.index');
    }

    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',Role::class);
        try {
            return $this->roleService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status role: ' . $e->getMessage()
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
     */
    public function store(RoleCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Role::class);
        try {
            $this->roleService->store($request);
            return redirect()->route('backend.roles.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param Role $role
     * @return JsonResponse|View
     */
    public function show($lang, Role $role): JsonResponse|View
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
     * @param $lang
     * @param Role $role
     * @return JsonResponse|View
     */
    public function edit($lang, Role $role): JsonResponse|View
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
                'message' => 'Failed to editing the role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param RoleUpdateRequest $request
     * @param Role $role
     * @return JsonResponse|View
     */
    public function update($lang, RoleUpdateRequest $request, Role $role): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $role);
        try {
            $this->roleService->update($request, $role);
            return redirect()->route('backend.roles.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating role: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Permission.
     * @param $lang
     * @param Role $role
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, Role $role): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $role);
        try {
            $this->roleService->destroy($role);
            return redirect()->route('backend.roles.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Permission.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', Role::class);
        try {
            $this->roleService->massDestroy($request);
            return redirect()->route('backend.roles.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting role: ' . $e->getMessage()
            ], 500);
        }
    }

    // Archive

    /**
     * View all Roles in Trash.
     *
     * @param RolesDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(RolesDataTableTrash $dataTable)
    {
        $this->authorize('trash', Role::class);
        return $dataTable->render('backend.roles.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Role::class);
        try {
            $this->roleService->restore($id);
            return redirect()->route('backend.roles.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring role: ' . $e->getMessage()
            ], 500);
        }

    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Role::class);
        try {
            $this->roleService->remove($id);
            return redirect()->route('backend.roles.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing role: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Role::class);
        try {
            $this->roleService->massRemove($request);
            return redirect()->route('backend.roles.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing role: ' . $e->getMessage()
            ], 500);
        }
    }
}
