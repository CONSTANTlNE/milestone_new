<?php
namespace App\Contracts;

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
use App\Models\Role;

interface RoleInterface
{
    public function index(RoleIndexRequest $request);
    public function changeStatus(RoleChangeStatusRequest $request);
    public function store(RoleCreateRequest $request);
    public function show(Role $role);
    public function edit(Role $role);
    public function update(RoleUpdateRequest $request, Role $role);
    public function destroy(RoleDestroyRequest $request);
    public function massDestroy(RoleMassDestroyRequest $request);
    public function trash(RoleTrashRequest $request);
    public function restore(RoleRestoreRequest $request);
    public function remove(RoleRemoveRequest $request);
    public function massRemove(RoleMassRemoveRequest $request);
}
