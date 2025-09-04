<?php

namespace App\Services;

use App\Contracts\PermissionInterface;
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
use App\Http\Resources\Permission\PermissionResource;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Permission;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

class PermissionService implements PermissionInterface
{
    use MultiTranslatableTrait;
    const CACHE_TTL = 86400; // 1 day

    public function index(PermissionIndexRequest $request): LengthAwarePaginator
    {
        return Permission::select(['id', 'title', 'name', 'created_at', 'status'])
            ->filter($request)
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function getAllRoutes(): array
    {
        $routeCollection = collect(Route::getRoutes())
            ->filter(function ($route) {
                $name = $route->getName();
                return str_starts_with($name, 'backend.') && $name !== 'backend.';
            });
//        $routeCollection = Route::getRoutes()->getIterator();
        $arr = [];
        foreach ($routeCollection as $value) {
            $arr[] = $value->getName();
        }
        return array_unique($arr);
    }

    public function changeStatus(PermissionChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('permissions');

        $permission = Permission::find($data['id']);

        if (!$permission) {
            return response()->json([
                'message' => 'Permission not found',
                'alert-type' => 'error'
            ], 404);
        }

        $permission->update(['status' => $data['status']]);
        $permission->save();

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(PermissionCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('permissions');

        $permission = new Permission();
        $permission->setMultiTranslations($data);
        $permission->name = $data['name'];
        $permission->status = $data['status'];
        $permission->created_at = $data['published_at'] ?? now();
        $permission->save();
        $permission->fresh();

        return response()->json([
            'page' => PermissionResource::make($permission),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Permission $permission): JsonResponse|Permission
    {
        return $permission;
    }

    public function edit(Permission $permission): JsonResponse|Permission
    {
        return $permission;
    }

    public function update(PermissionUpdateRequest $request, Permission $permission): JsonResponse
    {
        $data = $request->validated();

        Cache::forget('permissions');
        $permission->setMultiTranslations($data);
        $permission->name = $data['name'];
        $permission->status = $data['status'];
        $permission->created_at = $data['published_at'] ?? now();
        $permission->save();
        $permission->fresh();

        return response()->json([
            'page' => PermissionResource::make($permission),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }
    public function destroy(PermissionDestroyRequest $request): JsonResponse
    {
        Cache::forget('permissions');
        $permission = Permission::find($request->id);
        if (!$permission) {
            return response()->json([
                'message' => 'Permission not found',
                'alert-type' => 'error'
            ], 404);
        }
        $permission->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(PermissionMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('permissions');
        Permission::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function trash(PermissionTrashRequest $request): LengthAwarePaginator
    {
        return Permission::select(['id', 'title', 'created_at'])
            ->filterTrash($request)
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function restore(PermissionRestoreRequest $request): JsonResponse
    {
        Cache::forget('permissions');
        $permission = Permission::where('id', $request->id)->withTrashed()->first();
        $permission->restore();
        $permission->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function remove(PermissionRemoveRequest $request): JsonResponse
    {
        Cache::forget('permissions');
        $data = Permission::withTrashed()->where('id', $request->id)->first();
        $data->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function massRemove(PermissionMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('permissions');
        Permission::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
}
