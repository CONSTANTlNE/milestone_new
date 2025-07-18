<?php
namespace App\Contracts;

use App\Http\Requests\Page\PageChangeStatusRequest;
use App\Http\Requests\Page\PageCreateRequest;
use App\Http\Requests\Page\PageDestroyRequest;
use App\Http\Requests\Page\PageIndexRequest;
use App\Http\Requests\Page\PageMassDestroyRequest;
use App\Http\Requests\Page\PageMassRemoveRequest;
use App\Http\Requests\Page\PageRemoveRequest;
use App\Http\Requests\Page\PageRestoreRequest;
use App\Http\Requests\Page\PageTrashRequest;
use App\Http\Requests\Page\PageUpdateRequest;
use App\Models\Page;

interface PageInterface
{
    public function index(PageIndexRequest $request);
    public function getSeoFirst(Page $page);
    public function changeStatus(PageChangeStatusRequest $request);
    public function store(PageCreateRequest $request);
    public function show(Page $page);
    public function edit(Page $page);
    public function update(PageUpdateRequest $request, Page $page);
    public function destroy(PageDestroyRequest $request);
    public function massDestroy(PageMassDestroyRequest $request);
    public function trash(PageTrashRequest $request);
    public function restore(PageRestoreRequest $request);
    public function remove(PageRemoveRequest $request);
    public function massRemove(PageMassRemoveRequest $request);
}
