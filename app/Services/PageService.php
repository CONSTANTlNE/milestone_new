<?php

namespace App\Services;

use App\Contracts\PageInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Page\PageCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Page\PageRemoveRequest;
use App\Http\Requests\Page\PageRestoreRequest;
use App\Http\Requests\Page\PageUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Resources\Page\PageResource;
use App\Http\Resources\Page\PagesResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Page;
use Illuminate\Support\Facades\Cache;

class PageService implements PageInterface
{
    use MenuTrait, ImageUploadTrait, MultiTranslatableTrait;

    public function getSeoFirst(Page $page)
    {
        return $page->seo()->first();
    }
    public function changeStatus(ChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Page');

        $page = Page::find($data['id']);
        $page->update(['status' => $data['status']]);

        $page->setActive($data['status']);

        return  response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(PageCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Page');

        $page = new Page();
        $page->setMultiTranslations($data);
        $page->status = $data['status'];
//        if($data['parent_id']){
//            $page->parent_id = $data['parent_id'];
//        }
        $page->position = Page::getNextPosition();
        $page->save();
        // Set SEO translations if available
        $page->setSeoTranslations($data);
        $this->processAndSaveImages($data, $page);
        $page->fresh();

        return response()->json([
            'page' => PageResource::make($page),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Page $page): JsonResponse|Page
    {
        return $page;
    }

    public function edit(Page $page): Page
    {
        return $page;
    }

    public function update(PageUpdateRequest $request, Page $page): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Page');
        $page->setMultiTranslations($data);
        $page->status = $data['status'];
//      if($data['parent_id']){
//            $page->parent_id = $data['parent_id'];
//      }
        $page->position = Page::getNextPosition();
        $page->save();
        // Set Menu translations if available
        $page->setMenuTranslations(
            $page->getTranslations('title'),
            $page->getTranslations('slug')
        );
        $page->setActive($data['status']);
        // Set SEO translations if available
        $page->setSeoTranslations($data);
        $this->processAndSaveImages($data, $page);
        $page->fresh();

        return response()->json([
            'page' => PageResource::make($page),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(Page $page): JsonResponse
    {
        $page->setActive(false);
        $page->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('Page');
        $pages = Page::whereIn('id', $request->ids);
        foreach ($pages as $page) {
            $page->setActive(false);
        }
        $pages->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function restore($id): void
    {
        Cache::forget('Page');
        $page = Page::where('id', $id)->withTrashed()->first();
        $page->restore();
        $page->setActive(false);
        $page->fresh();
    }

    public function remove(RemoveRequest $page): JsonResponse
    {
        Cache::forget('Page');
        Cache::forget('generalPage'.$page->id);
        Cache::forget('statusImageShowPage'.$page->id);
        Cache::forget('mainPdfShowPage'.$page->id);
        Cache::forget('defaultImageShowPage'.$page->id);
        $data = Page::where('id', $page->id)->withTrashed()->first();
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
        Cache::forget('Page');
        $pages = Page::whereIn('id', $request->ids)->get();
        foreach ($pages as $page) {
            Cache::forget('generalPage'.$page->id);
            Cache::forget('statusImageShowPage'.$page->id);
            Cache::forget('mainPdfShowPage'.$page->id);
            Cache::forget('defaultImageShowPage'.$page->id);
            $page->seo()->forceDelete();
            $page->setForceDelete(true);
            $page->images()->detach();
        }

        Page::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
