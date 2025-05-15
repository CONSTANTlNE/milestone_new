<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Permission\PermissionCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Permission\PermissionUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Permission;

interface PermissionInterface
{
    public function getAllRoutes();
    public function store(PermissionCreateRequest $request);

    public function show(Permission $permission);

    public function edit(Permission $permission);

    public function update(PermissionUpdateRequest $request, Permission $permission);

    public function destroy(Permission $permission);

    public function massDestroy(MassDestroyRequest $request);

    public function restore(Permission $permission);

    public function remove(RemoveRequest $permission);

    public function massRemove(MassRemoveRequest $request);
}
