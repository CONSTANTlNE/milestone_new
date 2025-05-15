<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Partner\PartnerCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Partner\PartnerUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Partner;

interface PartnerInterface
{
    public function getPartnerPosition();
    public function getPartners();

    public function getSeoFirst(Partner $partner);

    public function changeStatus(ChangeStatusRequest $request);

    public function store(PartnerCreateRequest $request);

    public function show(Partner $partner);

    public function edit(Partner $partner);

    public function update(PartnerUpdateRequest $request, Partner $partner);

    public function destroy(Partner $partner);

    public function massDestroy(MassDestroyRequest $request);

    public function reorder(array $data);

    public function remove(RemoveRequest $partner);

    public function massRemove(MassRemoveRequest $request);
}
