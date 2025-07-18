<?php
namespace App\Contracts;

use App\Http\Requests\Blog\BlogChangeStatusRequest;
use App\Http\Requests\Blog\BlogCreateRequest;
use App\Http\Requests\Blog\BlogDestroyRequest;
use App\Http\Requests\Blog\BlogIndexRequest;
use App\Http\Requests\Blog\BlogMassDestroyRequest;
use App\Http\Requests\Blog\BlogMassRemoveRequest;
use App\Http\Requests\Blog\BlogRemoveRequest;
use App\Http\Requests\Blog\BlogRestoreRequest;
use App\Http\Requests\Blog\BlogTrashRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Models\Blog;
interface BlogInterface
{
    public function index(BlogIndexRequest $request);
    public function getSeoFirst(Blog $blog);
    public function changeStatus(BlogChangeStatusRequest $request);
    public function store(BlogCreateRequest $request);
    public function show(Blog $blog);
    public function edit(Blog $blog);
    public function update(BlogUpdateRequest $request, Blog $blog);
    public function destroy(BlogDestroyRequest $request);
    public function massDestroy(BlogMassDestroyRequest $request);
    public function trash(BlogTrashRequest $request);
    public function restore(BlogRestoreRequest $request);
    public function remove(BlogRemoveRequest $request);
    public function massRemove(BlogMassRemoveRequest $request);
}
