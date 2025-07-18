<?php
namespace App\Contracts;

use App\Http\Requests\Service\ServiceChangeStatusRequest;
use App\Http\Requests\Service\ServiceCreateRequest;
use App\Http\Requests\Service\ServiceDestroyRequest;
use App\Http\Requests\Service\ServiceIndexRequest;
use App\Http\Requests\Service\ServiceMassDestroyRequest;
use App\Http\Requests\Service\ServiceMassRemoveRequest;
use App\Http\Requests\Service\ServiceRemoveRequest;
use App\Http\Requests\Service\ServiceRestoreRequest;
use App\Http\Requests\Service\ServiceTrashRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Models\Service;

interface ServiceInterface
{
    public function index(ServiceIndexRequest $request);
    public function getSeoFirst(Service $service);
    public function changeStatus(ServiceChangeStatusRequest $request);
    public function store(ServiceCreateRequest $request);
    public function show(Service $service);
    public function edit(Service $service);
    public function update(ServiceUpdateRequest $request, Service $service);
    public function destroy(ServiceDestroyRequest $request);
    public function massDestroy(ServiceMassDestroyRequest $request);
    public function trash(ServiceTrashRequest $request);
    public function restore(ServiceRestoreRequest $request);
    public function remove(ServiceRemoveRequest $request);
    public function massRemove(ServiceMassRemoveRequest $request);
}
