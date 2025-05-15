<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Role\RoleCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Role;

interface RoleInterface
{
    public function create();
    public function store(RoleCreateRequest $request);

    public function show(Role $role);

    public function edit(Role $role);

    public function update(RoleUpdateRequest $request, Role $role);

    public function destroy(Role $role);

    public function massDestroy(MassDestroyRequest $request);

    public function restore(Role $role);

    public function remove(RemoveRequest $role);

    public function massRemove(MassRemoveRequest $request);
}
