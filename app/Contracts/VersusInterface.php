<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Versus\VersusCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Versus\VersusUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Article;

interface VersusInterface
{
    public function getSeoFirst(Article $article);

    public function changeStatus(ChangeStatusRequest $request);

    public function store(VersusCreateRequest $request);

    public function show(Article $article);

    public function edit(Article $article);

    public function update(VersusUpdateRequest $request, Article $article);

    public function destroy(Article $article);

    public function massDestroy(MassDestroyRequest $request);

    public function restore(Article $article);

    public function remove(RemoveRequest $article);

    public function massRemove(MassRemoveRequest $request);
}
