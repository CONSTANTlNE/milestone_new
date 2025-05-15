<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Team\TeamCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Team\TeamUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Team;

interface TeamInterface
{
    public function getTeamPosition();

    public function getSeoFirst(Team $team);

    public function changeStatus(ChangeStatusRequest $request);

    public function store(TeamCreateRequest $request);

    public function show(Team $team);

    public function edit(Team $team);

    public function update(TeamUpdateRequest $request, Team $team);

    public function destroy(Team $team);

    public function massDestroy(MassDestroyRequest $request);

    public function reorder(Team $team);

    public function restore(Team $team);

    public function remove(RemoveRequest $team);

    public function massRemove(MassRemoveRequest $request);
}
