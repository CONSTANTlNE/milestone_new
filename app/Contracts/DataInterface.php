<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Data\DataCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Data\DataUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Data;

interface DataInterface
{
    public function getSeoFirst(Data $data);
    public function changeStatus(ChangeStatusRequest $request);

    public function store(DataCreateRequest $request);

    public function show(Data $data);

    public function edit(Data $data);

    public function update(DataUpdateRequest $request, Data $data);

    public function destroy(Data $data);

    public function massDestroy(MassDestroyRequest $request);

    public function restore(Data $data);

    public function remove(RemoveRequest $data);

    public function massRemove(MassRemoveRequest $request);
}
