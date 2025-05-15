<?php

namespace App\Services;

use App\Contracts\RoleInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Role\RoleCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Role\RolesResource;
use App\Models\Permission;
use App\Traits\ImageUploadTrait;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;
use Route;

class RoleService implements RoleInterface
{
    use MenuTrait, ImageUploadTrait, MultiTranslatableTrait;
    const CACHE_TTL = 86400; // 1 day

    public function getPermission()
    {
        return Permission::all();
    }

    public function getRolePermission($role)
    {
        return Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$role->id)
            ->get();
    }

    public function getRoleAllPermission($role): array
    {
        return Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$role->id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    }

    public function create()
    {
        return Role::where('status','1')->orderBy('id','desc')->get();
    }

    /**
     * @throws BindingResolutionException
     */
    public function store(RoleCreateRequest $request): JsonResponse
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $data = $request->validated();
        Cache::forget('Role');

        $role = new Role();
        $role->setMultiTranslations($data);
        $role->name = $data['name'];
        $role->has_backend_access = $data['has_backend_access'];
        $role->position = Role::getNextPosition();
        $role->save();
        if (!empty($data['permission'])) {
            $role->syncPermissions(array_map(fn($val)=>(int)$val, $data['permission']));
        }
        $role->fresh();

        return response()->json([
            'role' => RoleResource::make($role),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Role $role): JsonResponse|Role
    {
        return $role;
    }

    public function edit(Role $role): Role
    {
        return $role;
    }

    public function update(RoleUpdateRequest $request, Role $role): JsonResponse
    {
        $data = $request->validated();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Cache::forget('Role');
        $role->setMultiTranslations($data);
        $role->has_backend_access = $data['has_backend_access'];
        $role->position = Role::getNextPosition();
        $role->save();
        $role->syncPermissions(array_map(fn($val)=>(int)$val, $data['permission']));
        $role->fresh();

        return response()->json([
            'role' => RoleResource::make($role),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(Role $role): JsonResponse
    {
        $role->delete();
        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('Role');
        $roles = Role::whereIn('id', $request->ids);
        $roles->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function restore($id): void
    {
        Cache::forget('Role');
        $role = Role::where('id', $id)->withTrashed()->first();
        $role->restore();
        $role->fresh();
    }

    public function remove($id): JsonResponse
    {
        Cache::forget('Role');
        $role = Role::where('id', $id)->withTrashed()->first();
        $role->forceDelete();
        $role->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 204);
    }

    public function massRemove(MassRemoveRequest $request): JsonResponse
    {
        Cache::forget('Role');
        Role::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
