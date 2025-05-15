<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Banner\BannerCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Banner\BannerUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Banner;

interface BannerInterface
{
    public function getBannerPosition();
    public function getBanners();
    public function getSeoFirst(Banner $banner);
    public function changeStatus(ChangeStatusRequest $request);

    public function store(BannerCreateRequest $request);

    public function show(Banner $banner);

    public function edit(Banner $banner);

    public function update(BannerUpdateRequest $request, Banner $banner);

    public function destroy(Banner $banner);

    public function massDestroy(MassDestroyRequest $request);

    public function reorder(array $data);

    public function remove(RemoveRequest $request);

    public function massRemove(MassRemoveRequest $request);
}
