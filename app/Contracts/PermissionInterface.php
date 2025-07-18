<?php
namespace App\Contracts;

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
use App\Models\Permission;

interface PermissionInterface
{
    public function index(PermissionIndexRequest $request);
    public function getAllRoutes();
    public function changeStatus(PermissionChangeStatusRequest $request);
    public function store(PermissionCreateRequest $request);
    public function show(Permission $permission);
    public function edit(Permission $permission);
    public function update(PermissionUpdateRequest $request, Permission $permission);
    public function destroy(PermissionDestroyRequest $request);
    public function massDestroy(PermissionMassDestroyRequest $request);
    public function trash(PermissionTrashRequest $request);
    public function restore(PermissionRestoreRequest $request);
    public function remove(PermissionRemoveRequest $request);
    public function massRemove(PermissionMassRemoveRequest $request);
}
