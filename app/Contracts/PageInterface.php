<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Page\PageCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Page\PageUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Page;

interface PageInterface
{
    public function getSeoFirst(Page $page);
    public function changeStatus(ChangeStatusRequest $request);

    public function store(PageCreateRequest $request);

    public function show(Page $page);

    public function edit(Page $page);

    public function update(PageUpdateRequest $request, Page $page);

    public function destroy(Page $page);

    public function massDestroy(MassDestroyRequest $request);

    public function restore(Page $page);

    public function remove(RemoveRequest $page);

    public function massRemove(MassRemoveRequest $request);
}
