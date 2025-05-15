<?php

namespace App\Services;

use App\Contracts\PermissionInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Permission\PermissionCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Permission\PermissionUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Resources\Permission\PermissionResource;
use App\Http\Resources\Permission\PermissionsResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Route;

class PermissionService implements PermissionInterface
{
    use MenuTrait, ImageUploadTrait, MultiTranslatableTrait;
    const CACHE_TTL = 86400; // 1 day

    public function getAllRoutes(): array
    {
        $routeCollection = Route::getRoutes()->getIterator();
        $arr = [];
        foreach ($routeCollection as $value) {
            $arr[] = $value->getName();
        }
        return array_unique($arr);
    }

    public function store(PermissionCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Permission');

        $permission = new Permission();
        $permission->setMultiTranslations($data);
        $permission->name = $data['name'];
        $permission->position = Permission::getNextPosition();
        $permission->save();
        $permission->fresh();

        return response()->json([
            'permission' => PermissionResource::make($permission),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Permission $permission): JsonResponse|Permission
    {
        return $permission;
    }

    public function edit(Permission $permission): Permission
    {
        return $permission;
    }

    public function update(PermissionUpdateRequest $request, Permission $permission): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Permission');
        $permission->setMultiTranslations($data);
        $permission->name = $data['name'];
        $permission->position = Permission::getNextPosition();
        $permission->save();
        $permission->fresh();

        return response()->json([
            'permission' => PermissionResource::make($permission),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(Permission $permission): JsonResponse
    {
        $permission->delete();
        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('Permission');
        $permissions = Permission::whereIn('id', $request->ids);
        $permissions->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function restore($id): void
    {
        Cache::forget('Page');
        $permission = Permission::where('id', $id)->withTrashed()->first();
        $permission->restore();
        $permission->fresh();
    }

    public function remove($id): JsonResponse
    {
        Cache::forget('Permission');
        $data = Permission::where('id', $id)->withTrashed()->first();
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 204);
    }

    public function massRemove(MassRemoveRequest $request): JsonResponse
    {
        Cache::forget('Permission');
        Permission::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
