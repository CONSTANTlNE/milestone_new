<?php
namespace App\Contracts;

use App\Http\Requests\BlogCategory\BlogCategoryChangeStatusRequest;
use App\Http\Requests\BlogCategory\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategory\BlogCategoryDestroyRequest;
use App\Http\Requests\BlogCategory\BlogCategoryIndexRequest;
use App\Http\Requests\BlogCategory\BlogCategoryMassDestroyRequest;
use App\Http\Requests\BlogCategory\BlogCategoryMassRemoveRequest;
use App\Http\Requests\BlogCategory\BlogCategoryRemoveRequest;
use App\Http\Requests\BlogCategory\BlogCategoryRestoreRequest;
use App\Http\Requests\BlogCategory\BlogCategoryTrashRequest;
use App\Http\Requests\BlogCategory\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;

interface BlogCategoryInterface
{
    public function index(BlogCategoryIndexRequest $request);
    public function getSeoFirst(BlogCategory $blogCategory);
    public function changeStatus(BlogCategoryChangeStatusRequest $request);
    public function store(BlogCategoryCreateRequest $request);
    public function show(BlogCategory $blogCategory);
    public function edit(BlogCategory $blogCategory);
    public function update(BlogCategoryUpdateRequest $request, BlogCategory $blogCategory);
    public function destroy(BlogCategoryDestroyRequest $request);
    public function massDestroy(BlogCategoryMassDestroyRequest $request);
    public function trash(BlogCategoryTrashRequest $request);
    public function restore(BlogCategoryRestoreRequest $request);
    public function remove(BlogCategoryRemoveRequest $request);
    public function massRemove(BlogCategoryMassRemoveRequest $request);
}
