<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Media\MediaCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Media\MediaUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Media;

interface MediaInterface
{
    public function getMedias();

    public function changeStatus(ChangeStatusRequest $request);

    public function store(MediaCreateRequest $request);

    public function show(Media $media);

    public function edit(Media $media);

    public function update(MediaUpdateRequest $request, Media $media);

    public function destroy(Media $media);

    public function massDestroy(MassDestroyRequest $request);

    public function remove(RemoveRequest $media);

    public function massRemove(MassRemoveRequest $request);
}
