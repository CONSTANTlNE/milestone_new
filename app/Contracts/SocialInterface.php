<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Requests\Social\SocialCreateRequest;
use App\Http\Requests\Social\SocialUpdateRequest;
use App\Models\Social;

interface SocialInterface
{
    public function getSocial();
    public function changeStatus(ChangeStatusRequest $request);
    public function store(SocialCreateRequest $request);
    public function show(Social $social);
    public function edit(Social $social);
    public function update(SocialUpdateRequest $request, Social $social);
    public function destroy(Social $social);
    public function massDestroy(MassDestroyRequest $request);
    public function reorder(array $data);
    public function getSocialTrash();
    public function restore(Social $social);
    public function remove(RemoveRequest $social);
    public function massRemove(MassRemoveRequest $request);
}
