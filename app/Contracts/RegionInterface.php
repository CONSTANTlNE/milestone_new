<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Region\RegionCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Region\RegionUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Region;

interface RegionInterface
{
    public function getSeoFirst(Region $region);

    public function changeStatus(ChangeStatusRequest $request);

    public function store(RegionCreateRequest $request);

    public function show(Region $region);

    public function edit(Region $region);

    public function update(RegionUpdateRequest $request, Region $region);

    public function destroy(Region $region);

    public function massDestroy(MassDestroyRequest $request);

    public function remove(RemoveRequest $region);

    public function massRemove(MassRemoveRequest $request);
}
