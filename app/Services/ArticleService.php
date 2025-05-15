<?php

namespace App\Services;

use App\Contracts\ArticleInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Article\ArticleCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Article\ArticleUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Article\ArticlesResource;
use App\Models\Tag;
use App\Traits\ImageUploadTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ArticleService implements ArticleInterface
{
    use ImageUploadTrait, MultiTranslatableTrait;

    public function getSeoFirst(Article $article)
    {
        return $article->seo()->first();
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

    public function store(ArticleCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Article');
        $article = new Article();
        $article->setMultiTranslations($data);
        $article->status = $data['status'];
        $article->verdict_id = $data['verdict'];
        $article->type = 1;
        if (isset($data['options'])){
            $article->option_id = json_encode($data['options']);
        }
        $reporter = $data['reporter'] == 0 ? Auth::user()->id : $data['reporter'];
        $article->user_id = $reporter;
        $article->position = Article::getNextPosition();
        $article->created_at = $request->published_at ?? now();
        $article->save();

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
            'article' => ArticleResource::make($article),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Article $article): JsonResponse|Article
    {
        return $article;
    }

    public function edit(Article $article): Article
    {
        return $article;
    }

    public function update(ArticleUpdateRequest $request, Article $article): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Article');
        $article->setMultiTranslations($data);
        $article->status = $data['status'];
        $article->verdict_id = $data['verdict'] != 0 ? $data['verdict'] : null;
        $article->option_id = isset($data['options']) ? json_encode($data['options']) : [];
        $reporter = $data['reporter'] == 0 ? Auth::user()->id : $data['reporter'];
        $article->user_id = $reporter;
        $article->position = Article::getNextPosition();
        $article->created_at = $request->published_at ?? now();
        $article->save();

        if (isset($data['persons'])) {
            $article->persons()->sync($data['persons']);
        }else{
            $article->persons()->detach();
        }

        if (isset($data['category'])) {
            $article->categories()->sync($data['category']);
        }else{
            $article->categories()->detach();
        }
        if (isset($data['region']) && $data['region'] != 0) {
            $article->regions()->sync($data['region']);
        }else{
            $article->regions()->detach();
        }

        if (isset($data['tags'])){
            $article->setTagTranslations($data);
        }

        // Set SEO translations if available
        $article->setSeoTranslations($data);
        $this->processAndSaveImages($data, $article);
        $article->fresh();

        return response()->json([
            'article' => ArticleResource::make($article),
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
