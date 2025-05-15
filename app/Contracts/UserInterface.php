<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\User;

interface UserInterface
{
    public function store(UserCreateRequest $request);

    public function show(User $user);

    public function edit(User $user);

    public function update(UserUpdateRequest $request, User $user);

    public function destroy(User $user);

    public function massDestroy(MassDestroyRequest $request);

    public function restore(User $user);

    public function remove(RemoveRequest $user);

    public function massRemove(MassRemoveRequest $request);
}
