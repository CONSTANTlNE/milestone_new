<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Article\ArticleCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Article\ArticleUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Article;

interface ArticleInterface
{
    public function getSeoFirst(Article $article);

    public function changeStatus(ChangeStatusRequest $request);

    public function store(ArticleCreateRequest $request);

    public function show(Article $article);

    public function edit(Article $article);

    public function update(ArticleUpdateRequest $request, Article $article);

    public function destroy(Article $article);

    public function massDestroy(MassDestroyRequest $request);

    public function restore(Article $article);

    public function remove(RemoveRequest $article);

    public function massRemove(MassRemoveRequest $request);
}
