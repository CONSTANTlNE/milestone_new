<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Requests\Locale\LocaleCreateRequest;
use App\Http\Requests\Locale\LocaleUpdateRequest;
use App\Models\Locale;

interface LocaleInterface
{
    public function getLocales();
    public function changeStatus(Locale $locale);
    public function general(Locale $locale);
    public function store(LocaleCreateRequest $request);
    public function show(Locale $locale);
    public function edit(Locale $locale);
    public function update(LocaleUpdateRequest $request, Locale $locale);
    public function destroy(Locale $locale);
    public function massDestroy(MassDestroyRequest $request);
    public function reorder(array $data);
    public function getLocaleTrash();
    public function restore(Locale $locale);
    public function remove(RemoveRequest $locale);
    public function massRemove(MassRemoveRequest $request);
}
