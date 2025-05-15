<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\ArticleCategory\ArticleCategoryCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\ArticleCategory\ArticleCategoryUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\ArticleCategory;

interface ArticleCategoryInterface
{
    public function getSeoFirst(ArticleCategory $articleCategory);

    public function changeStatus(ChangeStatusRequest $request);

    public function store(ArticleCategoryCreateRequest $request);

    public function show(ArticleCategory $articleCategory);

    public function edit(ArticleCategory $articleCategory);

    public function update(ArticleCategoryUpdateRequest $request, ArticleCategory $articleCategory);

    public function destroy(ArticleCategory $articleCategory);

    public function massDestroy(MassDestroyRequest $request);

    public function restore(ArticleCategory $articleCategory);

    public function remove(RemoveRequest $articleCategory);

    public function massRemove(MassRemoveRequest $request);
}
