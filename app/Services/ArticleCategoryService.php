<?php

namespace App\Services;

use App\Contracts\ArticleCategoryInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\ArticleCategory\ArticleCategoryCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\ArticleCategory\ArticleCategoryUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Resources\ArticleCategory\ArticleCategoryResource;
use App\Http\Resources\ArticleCategory\ArticleCategoriesResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\ArticleCategory;
use Illuminate\Support\Facades\Cache;

class ArticleCategoryService implements ArticleCategoryInterface
{
    use MenuTrait, ImageUploadTrait, MultiTranslatableTrait;
    public function getArticleCategoriesParent()
    {
        return ArticleCategory::where('parent_id', null)->where('status', 1)->get();
    }

    public function getSeoFirst(ArticleCategory $articleCategory)
    {
        return $articleCategory->seo()->first();
    }
    public function changeStatus(ChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('ArticleCategory');

        $articleCategory = ArticleCategory::find($data['id']);
        $articleCategory->update(['status' => $data['status']]);

        $articleCategory->setActive($data['status']);

        return  response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(ArticleCategoryCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('ArticleCategory');

        $articleCategory = new ArticleCategory();
        $articleCategory->setMultiTranslations($data);
        $articleCategory->status = $data['status'];
        if($data['parent_id']){
            $articleCategory->parent_id = $data['parent_id'];
        }
        $articleCategory->save();
        // Set SEO translations if available
        $articleCategory->setSeoTranslations($data);
        $this->processAndSaveImages($data, $articleCategory);
        $articleCategory->fresh();

        return response()->json([
            'ArticleCategory' => ArticleCategoryResource::make($articleCategory),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(ArticleCategory $articleCategory): JsonResponse|ArticleCategory
    {
        return $articleCategory;
    }

    public function edit(ArticleCategory $articleCategory): ArticleCategory
    {
        return $articleCategory;
    }

    public function update(ArticleCategoryUpdateRequest $request, ArticleCategory $articleCategory): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('ArticleCategory');
        $articleCategory->setMultiTranslations($data);
        $articleCategory->status = $data['status'];
        $articleCategory->parent_id = isset($data['parent_id']) != 0 ? $data['parent_id'] : null;
        $articleCategory->save();
        // Set Menu translations if available
        $articleCategory->setMenuTranslations(
            $articleCategory->getTranslations('title'),
            $articleCategory->getTranslations('slug')
        );
        $articleCategory->setActive($data['status']);
        // Set SEO translations if available
        $articleCategory->setSeoTranslations($data);
        $this->processAndSaveImages($data, $articleCategory);
        $articleCategory->fresh();

        return response()->json([
            'ArticleCategory' => ArticleCategoryResource::make($articleCategory),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(ArticleCategory $articleCategory): JsonResponse
    {
        $articleCategory->setActive(false);
        $articleCategory->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('ArticleCategory');
        $articleCategorys = ArticleCategory::whereIn('id', $request->ids);
        foreach ($articleCategorys as $articleCategory) {
            $articleCategory->setActive(false);
        }
        $articleCategorys->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function restore($id): void
    {
        Cache::forget('ArticleCategory');
        $articleCategory = ArticleCategory::where('id', $id)->withTrashed()->first();
        $articleCategory->restore();
        $articleCategory->setActive(false);
        $articleCategory->fresh();
    }

    public function remove($id): JsonResponse
    {
        Cache::forget('ArticleCategory');
        Cache::forget('generalPage'.$id);
        Cache::forget('statusImageShowPage'.$id);
        Cache::forget('mainPdfShowPage'.$id);
        Cache::forget('defaultImageShowPage'.$id);
        $data = ArticleCategory::where('id', $id)->withTrashed()->first();
        $data->articles()->detach();
        $data->seo()->forceDelete();
        $data->images()->detach();
        $data->setForceDelete(true);
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 204);
    }

    public function massRemove(MassRemoveRequest $request): JsonResponse
    {
        Cache::forget('ArticleCategory');
        $articleCategorys = ArticleCategory::whereIn('id', $request->ids)->get();
        foreach ($articleCategorys as $articleCategory) {
            Cache::forget('generalPage'.$articleCategory->id);
            Cache::forget('statusImageShowPage'.$articleCategory->id);
            Cache::forget('mainPdfShowPage'.$articleCategory->id);
            Cache::forget('defaultImageShowPage'.$articleCategory->id);
            $articleCategory->seo()->forceDelete();
            $articleCategory->setForceDelete(true);
            $articleCategory->images()->detach();
        }

        ArticleCategory::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
