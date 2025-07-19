<?php
namespace App\Contracts;

use App\Http\Requests\ServiceCategory\ServiceCategoryChangeStatusRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryCreateRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryDestroyRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryIndexRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryMassDestroyRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryMassRemoveRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryRemoveRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryRestoreRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryTrashRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryUpdateRequest;
use App\Models\ServiceCategory;

interface ServiceCategoryInterface
{
    public function index(ServiceCategoryIndexRequest $request);
    public function getSeoFirst(ServiceCategory $serviceCategory);
    public function changeStatus(ServiceCategoryChangeStatusRequest $request);
    public function store(ServiceCategoryCreateRequest $request);
    public function show(ServiceCategory $serviceCategory);
    public function edit(ServiceCategory $serviceCategory);
    public function update(ServiceCategoryUpdateRequest $request, ServiceCategory $serviceCategory);
    public function destroy(ServiceCategoryDestroyRequest $request);
    public function massDestroy(ServiceCategoryMassDestroyRequest $request);
    public function trash(ServiceCategoryTrashRequest $request);
    public function restore(ServiceCategoryRestoreRequest $request);
    public function remove(ServiceCategoryRemoveRequest $request);
    public function massRemove(ServiceCategoryMassRemoveRequest $request);
}
