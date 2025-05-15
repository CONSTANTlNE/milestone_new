<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Person\PersonCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Person\PersonUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Person;

interface PersonInterface
{
    public function getPersons();
    public function getSeoFirst(Person $person);
    public function changeStatus(ChangeStatusRequest $request);

    public function store(PersonCreateRequest $request);

    public function show(Person $person);

    public function edit(Person $person);

    public function update(PersonUpdateRequest $request, Person $person);

    public function destroy(Person $person);

    public function massDestroy(MassDestroyRequest $request);

    public function restore(Person $person);

    public function remove(RemoveRequest $person);

    public function massRemove(MassRemoveRequest $request);
}
