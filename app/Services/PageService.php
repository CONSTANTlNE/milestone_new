<?php

namespace App\Services;

use App\Contracts\PageInterface;
use App\Http\Requests\Page\PageChangeStatusRequest;
use App\Http\Requests\Page\PageCreateRequest;
use App\Http\Requests\Page\PageDestroyRequest;
use App\Http\Requests\Page\PageMassDestroyRequest;
use App\Http\Requests\Page\PageMassRemoveRequest;
use App\Http\Requests\Page\PageRemoveRequest;
use App\Http\Requests\Page\PageRestoreRequest;
use App\Http\Requests\Page\PageTrashRequest;
use App\Http\Requests\Page\PageUpdateRequest;
use App\Http\Resources\Page\PageResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Page;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Page\PageIndexRequest;

class PageService implements PageInterface
{
    use MenuTrait, ImageUploadTrait, MultiTranslatableTrait;

    public function index(PageIndexRequest $request): LengthAwarePaginator
    {
        return Page::select(['id', 'title', 'src', 'template', 'created_at', 'status'])
            ->filter($request)
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function getSeoFirst(Page $page)
    {
        return $page->seo()->first();
    }

    public function changeStatus(PageChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('pages');

        $page = Page::find($data['id']);

        if (!$page) {
            return response()->json([
                'message' => 'Page not found',
                'alert-type' => 'error'
            ], 404);
        }

        $page->update(['status' => $data['status']]);
        $page->setActive($data['status']);

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(PageCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('pages');

        $page = new Page();
        $page->setMultiTranslations($data);
        $page->status = $data['status'];
        $page->template = $data['template'];
        if(!empty($data['parent_id'])){
            $page->parent_id = $data['parent_id'];
        }
        $page->created_at = $data['published_at'] ?? now();
        $page->save();

        // Save features with translations using a private function, only if data exists
        $locales = array_keys(json_decode(file_get_contents(lang_path('config_locales.json')), true));
        $hasTiers = false;

        foreach ($locales as $locale) {
            if (!empty($request->input("tier_title_{$locale}", []))) {
                $hasTiers = true;
                break;
            }
        }

        if ($hasTiers) {
            $this->savePageTiers($request, $page, $locales);
        }

        $page->setSeoTranslations($data);
        $this->processAndSaveImages($data, $page, true);
        $page->fresh();

        return response()->json([
            'page' => PageResource::make($page),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    private function savePageTiers($request, Page $page, array $locales): void
    {
        $titles = [];
        $contents = [];
        foreach ($locales as $locale) {
            $titles[$locale] = $request->input("tier_title_{$locale}", []);
            $contents[$locale] = $request->input("tier_content_{$locale}", []);
        }
        $pageCount = count($contents[$locales[0]] ?? []);
        for ($i = 0; $i < $pageCount; $i++) {
            $titleTranslations = [];
            $contentTranslations = [];
            foreach ($locales as $locale) {
                $titleTranslations[$locale] = $titles[$locale][$i] ?? '';
                $contentTranslations[$locale] = $contents[$locale][$i] ?? '';
            }
            $page->tiers()->create([
                'title' => $titleTranslations,
                'content' => $contentTranslations,
                'page_id' => $page->id,
            ]);
        }
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
        Cache::forget('pages');
        $page->setMultiTranslations($data);
        $page->status = $data['status'];
        if(!empty($data['parent_id'])){
            $page->parent_id = $data['parent_id'];
        }else{
            $page->parent_id = null;
        }
        $page->created_at = $data['published_at'] ?? now();
        $page->save();
        // Set Menu translations if available
        $page->setMenuTranslations(
            $page->getTranslations('title'),
            $page->getTranslations('slug')
        );
        if ($data['status'] == 0){
            $page->setActive($data['status']);
        }

        // Save features with translations using a private function, only if data exists
        $locales = array_keys(json_decode(file_get_contents(lang_path('config_locales.json')), true));
        $hasTiers = false;

        foreach ($locales as $locale) {
            if (!empty($request->input("tier_title_{$locale}", []))) {
                $hasTiers = true;
                break;
            }
        }

        if ($hasTiers) {
            $page->tiers()->delete();
            $this->savePageTiers($request, $page, $locales);
        }


        // Set SEO translations if available
        $page->setSeoTranslations($data);
        $this->processAndSaveImages($data, $page, true);
        $page->fresh();

        return response()->json([
            'page' => PageResource::make($page),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(PageDestroyRequest $request): JsonResponse
    {
        Cache::forget('pages');
        $page = Page::find($request->id);
        if (!$page) {
            return response()->json([
                'message' => 'Page not found',
                'alert-type' => 'error'
            ], 404);
        }
        $page->setActive(false);
        $page->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(PageMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('pages');
        $pages = Page::whereIn('id', $request->ids)->get();
        foreach ($pages as $page) {
            $page->setActive(false);
        }
        Page::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function trash(PageTrashRequest $request): LengthAwarePaginator
    {
        return Page::select(['id', 'title', 'created_at'])
            ->filterTrash($request)
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function restore(PageRestoreRequest $request): JsonResponse
    {
        Cache::forget('pages');
        $page = Page::where('id', $request->id)->withTrashed()->first();
        $page->restore();
        $page->setActive(false);
        $page->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function remove(PageRemoveRequest $request): JsonResponse
    {
        Cache::forget('pages');
        $pageId = $request->id;
        $data = Page::where('id', $pageId)->withTrashed()->first();
        $data->seo()->forceDelete();
        $data->images()->detach();
        $data->tiers()->delete();
        $data->setForceDelete(true);
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function massRemove(PageMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('pages');
        $pages = Page::withTrashed()->whereIn('id', $request->ids)->get();

        foreach ($pages as $page) {
            $page->seo()->forceDelete();
            $page->setForceDelete(true);
            $page->tiers()->delete();
            $page->images()->detach();
        }

        Page::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function getPagesParent($excludePageId = null)
    {
        return Page::whereNull('parent_id')
            ->where('status', true)
            ->when($excludePageId, fn($query) => $query->where('id', '!=', $excludePageId))
            ->get();
    }
}
