<?php
namespace App\Contracts;

use App\Http\Requests\Locale\LocaleChangeStatusRequest;
use App\Http\Requests\Locale\LocaleCreateRequest;
use App\Http\Requests\Locale\LocaleDestroyRequest;
use App\Http\Requests\Locale\LocaleIndexRequest;
use App\Http\Requests\Locale\LocaleMassDestroyRequest;
use App\Http\Requests\Locale\LocaleMassRemoveRequest;
use App\Http\Requests\Locale\LocaleRemoveRequest;
use App\Http\Requests\Locale\LocaleRestoreRequest;
use App\Http\Requests\Locale\LocaleTrashRequest;
use App\Http\Requests\Locale\LocaleUpdateRequest;
use App\Models\Locale;

interface LocaleInterface
{
    public function index(LocaleIndexRequest $request);
    public function changeStatus(LocaleChangeStatusRequest $request);
    public function store(LocaleCreateRequest $request);
    public function show(Locale $locale);
    public function edit(Locale $locale);
    public function update(LocaleUpdateRequest $request, Locale $locale);
    public function destroy(LocaleDestroyRequest $request);
    public function massDestroy(LocaleMassDestroyRequest $request);
    public function reorder(array $data);
    public function trash(LocaleTrashRequest $request);
    public function restore(LocaleRestoreRequest $request);
    public function remove(LocaleRemoveRequest $request);
    public function massRemove(LocaleMassRemoveRequest $request);
}
