<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\PermissionsDataTable;
use App\DataTables\PermissionsDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\Permission\PermissionCreateRequest;
use App\Http\Requests\Permission\PermissionUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Services\PermissionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class PermissionController extends Controller
{
    private PermissionService $permissionService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
        $this->authorizeResource(Permission::class, 'permission');
    }
    /**
     * View all Permissions.
     *
     * @param PermissionsDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(PermissionsDataTable $dataTable)
    {
        $this->authorize('viewAny', Permission::class);
        return $dataTable->render('backend.permissions.index');
    }

    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',Permission::class);
        try {
            return $this->permissionService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status permission: ' . $e->getMessage()
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
     */
    public function store(PermissionCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Permission::class);
        try {
            $this->permissionService->store($request);
            return redirect()->route('backend.permissions.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating Permission: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param Permission $permission
     * @return JsonResponse|View
     */
    public function show($lang, Permission $permission): JsonResponse|View
    {
        $this->authorize('view', $permission);
        try {
            return view('backend.permissions.show', [
                'permission' => $this->permissionService->show($permission)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the Permission: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param Permission $permission
     * @return JsonResponse|View
     */
    public function edit($lang, Permission $permission): JsonResponse|View
    {
        $this->authorize('update', $permission);
        try {
            return view('backend.permissions.edit', [
                'permission' => $this->permissionService->edit($permission),
                'routes' => $this->permissionService->getAllRoutes()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the Permission: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param PermissionUpdateRequest $request
     * @param Permission $permission
     * @return JsonResponse|View
     */
    public function update($lang, PermissionUpdateRequest $request, Permission $permission): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $permission);
        try {
            $this->permissionService->update($request, $permission);
            return redirect()->route('backend.permissions.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating permission: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Permission.
     * @param $lang
     * @param Permission $permission
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, Permission $permission): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $permission);
        try {
            $this->permissionService->destroy($permission);
            return redirect()->route('backend.permissions.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting permission: ' . $e->getMessage()
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
        $this->authorize('delete', Permission::class);
        try {
            $this->permissionService->massDestroy($request);
            return redirect()->route('backend.permissions.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting permission: ' . $e->getMessage()
            ], 500);
        }
    }

    // Archive

    /**
     * View all Permissions in Trash.
     *
     * @param PermissionsDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(PermissionsDataTableTrash $dataTable)
    {
        $this->authorize('trash', Permission::class);
        return $dataTable->render('backend.permissions.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Permission::class);
        try {
            $this->permissionService->restore($id);
            return redirect()->route('backend.permissions.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring permission: ' . $e->getMessage()
            ], 500);
        }

    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Permission::class);
        try {
            $this->permissionService->remove($id);
            return redirect()->route('backend.permissions.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing permission: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Permission::class);
        try {
            $this->permissionService->massRemove($request);
            return redirect()->route('backend.permissions.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing permission: ' . $e->getMessage()
            ], 500);
        }
    }
}
