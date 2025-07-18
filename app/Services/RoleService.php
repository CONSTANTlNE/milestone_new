<?php

namespace App\Services;

use App\Contracts\RoleInterface;
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
use App\Http\Resources\Role\RoleResource;
use App\Models\Permission;
use App\Traits\ImageUploadTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use App\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class RoleService implements RoleInterface
{
    use ImageUploadTrait, MultiTranslatableTrait;
    const CACHE_TTL = 86400; // 1 day

    public function getPermission(): \Illuminate\Database\Eloquent\Collection
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
    public function index(RoleIndexRequest $request): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        return Role::query()
//            ->where('name', '!=', 'Super Admin')
            ->when($request->filled('search'), function ($query) use ($request, $locale) {
                $search = $request->search;
                $query->where(function ($q) use ($search, $locale) {
                    $q->whereRaw('CAST(id AS TEXT) ILIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw("title->>? ILIKE ?", [$locale, '%' . $search . '%'])
                        ->orWhereRaw("name ILIKE ?", ['%' . $search . '%']);
                });
            })
            ->when($request->filled('status') && $request->status !== 'all', function ($query) use ($request) {
                $query->where('has_backend_access', $request->status);
            })
            ->orderBy(
                $request->input('sort_column', 'id'),
                $request->input('sort_direction', 'desc')
            )
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function changeStatus(RoleChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('roles');

        $role = Role::find($data['id']);

        if (!$role) {
            return response()->json([
                'message' => 'Role not found',
                'alert-type' => 'error'
            ], 404);
        }

        $role->update(['has_backend_access' => $data['status']]);
        $role->save();

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }
    public function store(RoleCreateRequest $request): JsonResponse
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        Cache::forget('roles');
        $data = $request->validated();
        $role = new Role();
        $role->setMultiTranslations($data);
        $role->name = $data['name'];
        $role->has_backend_access = $data['has_backend_access'];
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
    public function edit(Role $role): JsonResponse|Role
    {
        return $role;
    }
    public function update(RoleUpdateRequest $request, Role $role): JsonResponse
    {
        $data = $request->validated();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Cache::forget('roles');
        $role->setMultiTranslations($data);
        $role->has_backend_access = $data['has_backend_access'];
        $role->save();
        $role->syncPermissions(array_map(fn($val)=>(int)$val, $data['permission']));
        $role->fresh();

        return response()->json([
            'role' => RoleResource::make($role),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(RoleDestroyRequest $request): JsonResponse
    {
        Cache::forget('roles');
        $role = Role::find($request->id);
        if (!$role) {
            return response()->json([
                'message' => 'Role not found',
                'alert-type' => 'error'
            ], 404);
        }
        $role->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }
    public function massDestroy(RoleMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('roles');
        Role::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method

    public function trash(RoleTrashRequest $request): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        return Role::onlyTrashed()
            ->when($request->filled('search'), function ($query) use ($request, $locale) {
                $search = $request->search;
                $query->where(function ($q) use ($search, $locale) {
                    $q->whereRaw('CAST(id AS TEXT) ILIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw("title->>? ILIKE ?", [$locale, '%' . $search . '%']);
                });
            })
            ->orderBy(
                $request->input('sort_column', 'id'),
                $request->input('sort_direction', 'desc')
            )
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }
    public function restore(RoleRestoreRequest $request): JsonResponse
    {
        Cache::forget('roles');
        $role = Role::where('id', $request->id)->withTrashed()->first();
        $role->restore();
        $role->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
    public function remove(RoleRemoveRequest $request): JsonResponse
    {
        Cache::forget('roles');
        $data = Role::withTrashed()->where('id', $request->id)->first();
        $data->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
    public function massRemove(RoleMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('roles');
        Role::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
}
