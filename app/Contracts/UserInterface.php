<?php
namespace App\Contracts;

use App\Http\Requests\User\UserChangeStatusRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserDestroyRequest;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserMassDestroyRequest;
use App\Http\Requests\User\UserMassRemoveRequest;
use App\Http\Requests\User\UserRemoveRequest;
use App\Http\Requests\User\UserRestoreRequest;
use App\Http\Requests\User\UserTrashRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;

interface UserInterface
{
    public function index(UserIndexRequest $request);
    public function changeStatus(UserChangeStatusRequest $request);
    public function store(UserCreateRequest $request);
    public function show(User $user);
    public function edit(User $user);
    public function update(UserUpdateRequest $request, User $user);
    public function destroy(UserDestroyRequest $request);
    public function massDestroy(UserMassDestroyRequest $request);
    public function trash(UserTrashRequest $request);
    public function restore(UserRestoreRequest $request);
    public function remove(UserRemoveRequest $request);
    public function massRemove(UserMassRemoveRequest $request);
}
