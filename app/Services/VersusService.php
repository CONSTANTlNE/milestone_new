<?php

namespace App\Services;

use App\Contracts\VersusInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Versus\VersusCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Versus\VersusUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Resources\Versus\VersusResource;
use App\Models\Tag;
use App\Models\Versus;
use App\Traits\ImageUploadTrait;
use App\Traits\MultiTranslatableTrait;
use App\Traits\VersusTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class VersusService implements VersusInterface
{
    use ImageUploadTrait, VersusTrait, MultiTranslatableTrait;

    public function getSeoFirst($id)
    {
        return Article::with('versus')->findOrFail($id)->seo()->first();
    }
    public function changeStatus(ChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Article');

        $article = Article::find($data['id']);
        $article->update(['status' => $data['status']]);

        return  response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(VersusCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Article');
        $article = new Article();
        $article->setMultiTranslations($data);
        $article->status = $data['status'];
        $article->type = 3;
        $article->verdict_id = $data['verdict'];
        $article->verdict_versus_id = $data['verdict2'];
        if (isset($data['options'])){
            $article->option_id = json_encode($data['options']);
        }
        $reporter = $data['reporter'] == 0 ? Auth::user()->id : $data['reporter'];
        $article->user_id = $reporter;
        $article->position = Article::getNextPosition();
        $article->save();
        $this->createOrUpdateVersus($article->id, $data);

        if (isset($data['persons'])) {
            $article->persons()->sync($data['persons']);
        }

        if (isset($data['category'])) {
            $article->categories()->sync($data['category']);
        }

        if (isset($data['region'])) {
            $article->regions()->sync($data['region']);
        }

        if (isset($data['tags'])){
            $article->setTagTranslations($data);
        }
        // Set SEO translations if available
        $article->setSeoTranslations($data);
        $this->processAndSaveImages($data, $article);
        $article->fresh();

        return response()->json([
            'versus' => VersusResource::make($article),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show($id)
    {

        return Article::with('versus')->findOrFail($id);
    }

    public function edit($id)
    {
        return Article::with('versus')->findOrFail($id);
    }

    public function update(VersusUpdateRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Article');
        $article = Article::findOrFail($id);
        $article->setMultiTranslations($data);
        $article->status = $data['status'];
        $article->verdict_id = $data['verdict'];
        $article->verdict_versus_id = $data['verdict2'];
        if (isset($data['options'])){
            $article->option_id = json_encode($data['options']);
        }
        $reporter = $data['reporter'] == 0 ? Auth::user()->id : $data['reporter'];
        $article->user_id = $reporter;
        $article->position = Article::getNextPosition();
        $article->save();
        $this->createOrUpdateVersus($article->id, $data);

        if (isset($data['persons'])) {
            $article->persons()->sync($data['persons']);
        }

        if (isset($data['region'])) {
            $article->regions()->sync($data['region']);
        }

        if (isset($data['category'])) {
            $article->categories()->sync($data['category']);
        }

        if (isset($data['tags'])){
            $article->setTagTranslations($data);
        }
        // Set SEO translations if available
        $article->setSeoTranslations($data);
        $this->processAndSaveImages($data, $article);
        $article->fresh();

        return response()->json([
            'versus' => VersusResource::make($article),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(Article $article): JsonResponse
    {
        $article->delete();
        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('Article');
        $articles = Article::whereIn('id', $request->ids);
        $articles->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function restore($id): void
    {
        Cache::forget('Article');
        $article = Article::where('id', $id)->withTrashed()->first();
        $article->restore();
        $article->fresh();
    }

    public function remove($id): JsonResponse
    {
        Cache::forget('Article');
        Cache::forget('generalArticle'.$id);
        Cache::forget('statusImageShowArticle'.$id);
        Cache::forget('mainPdfShowArticle'.$id);
        Cache::forget('defaultImageShowArticle'.$id);
        $data = Article::where('id', $id)->withTrashed()->first();
        $data->seo()->forceDelete();
        $data->images()->detach();
        $data->categories()->detach();
        $data->persons()->detach();
        $data->regions()->detach();
        $data->tags()->detach();
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 204);
    }

    public function massRemove(MassRemoveRequest $request): JsonResponse
    {
        Cache::forget('Article');
        $articles = Article::whereIn('id', $request->ids)->get();
        foreach ($articles as $article) {
            Cache::forget('generalArticle'.$article->id);
            Cache::forget('statusImageShowArticle'.$article->id);
            Cache::forget('mainPdfShowArticle'.$article->id);
            Cache::forget('defaultImageShowArticle'.$article->id);
            $article->seo()->forceDelete();
            $article->images()->detach();
        }

        Article::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
