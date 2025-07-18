<?php
namespace App\Contracts;

use App\Http\Requests\Social\SocialChangeStatusRequest;
use App\Http\Requests\Social\SocialCreateRequest;
use App\Http\Requests\Social\SocialDestroyRequest;
use App\Http\Requests\Social\SocialIndexRequest;
use App\Http\Requests\Social\SocialMassDestroyRequest;
use App\Http\Requests\Social\SocialMassRemoveRequest;
use App\Http\Requests\Social\SocialRemoveRequest;
use App\Http\Requests\Social\SocialRestoreRequest;
use App\Http\Requests\Social\SocialTrashRequest;
use App\Http\Requests\Social\SocialUpdateRequest;
use App\Models\Social;

interface SocialInterface
{
    public function index(SocialIndexRequest $request);
    public function changeStatus(SocialChangeStatusRequest $request);
    public function store(SocialCreateRequest $request);
    public function show(Social $social);
    public function edit(Social $social);
    public function update(SocialUpdateRequest $request, Social $social);
    public function destroy(SocialDestroyRequest $request);
    public function massDestroy(SocialMassDestroyRequest $request);
    public function reorder(array $data);
    public function trash(SocialTrashRequest $request);
    public function restore(SocialRestoreRequest $request);
    public function remove(SocialRemoveRequest $request);
    public function massRemove(SocialMassRemoveRequest $request);
}
