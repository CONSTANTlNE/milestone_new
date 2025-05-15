<?php

namespace App\Services;

use App\Contracts\RegionInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Region\RegionCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Region\RegionUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Requests\RewriteRequest;
use App\Http\Resources\Region\RegionResource;
use App\Http\Resources\Region\RegionsResource;
use App\Models\Article;
use App\Traits\ImageUploadTrait;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Region;
use Illuminate\Support\Facades\Cache;

class RegionService implements RegionInterface
{
    use MenuTrait, ImageUploadTrait, MultiTranslatableTrait;
    public function getRegions()
    {
        return Region::where('id', '>', 0)->pluck('title', 'id');
    }

    public function rewriteRegion(RewriteRequest $request): JsonResponse
    {

        $data = $request->validated();
        Cache::forget('Region');
        Cache::forget('Article');
        $firstIdRegion = Region::find($data['firstId']);
        $secondIdRegion = Region::find($data['secondId']);
        // Detach all articles from the first region
        $articleIds = $firstIdRegion->articles()->pluck('article_id')->toArray();
        $firstIdRegion->articles()->detach($articleIds);

        $secondIdRegion->articles()->attach($articleIds);

        return response()->json([
            'message' => __('strings.Rewrite Successfully')
        ], 201);
    }

    public function getSeoFirst(Region $region)
    {
        return $region->seo()->first();
    }
    public function changeStatus(ChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Region');

        $region = Region::find($data['id']);
        $region->update(['status' => $data['status']]);

        $region->setActive($data['status']);

        return  response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(RegionCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Region');

        $region = new Region();
        $region->setMultiTranslations($data);
        $region->status = $data['status'];
        $region->save();
        // Set SEO translations if available
        $region->setSeoTranslations($data);
        $this->processAndSaveImages($data, $region);
        $region->fresh();

        return response()->json([
            'region' => RegionResource::make($region),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Region $region): JsonResponse|Region
    {
        return $region;
    }

    public function edit(Region $region): Region
    {
        return $region;
    }

    public function update(RegionUpdateRequest $request, Region $region): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Region');
        $region->setMultiTranslations($data);
        $region->status = $data['status'];
        $region->position = Region::getNextPosition();
        $region->save();
        // Set Menu translations if available
        $region->setMenuTranslations(
            $region->getTranslations('title'),
            $region->getTranslations('slug')
        );
        $region->setActive($data['status']);
        // Set SEO translations if available
        $region->setSeoTranslations($data);
        $this->processAndSaveImages($data, $region);
        $region->fresh();

        return response()->json([
            'region' => RegionResource::make($region),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(Region $region): JsonResponse
    {
        $region->setActive(false);
        $region->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('Region');
        $regions = Region::whereIn('id', $request->ids);
        foreach ($regions as $region) {
            $region->setActive(false);
        }
        $regions->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function restore($id): void
    {
        Cache::forget('Region');
        $region = Region::where('id', $id)->withTrashed()->first();
        $region->restore();
        $region->setActive(false);
        $region->fresh();
    }

    public function remove($id): JsonResponse
    {
        Cache::forget('Region');
        Cache::forget('generalPage'.$id);
        Cache::forget('statusImageShowPage'.$id);
        Cache::forget('mainPdfShowPage'.$id);
        Cache::forget('defaultImageShowPage'.$id);
        $data = Region::where('id', $id)->withTrashed()->first();
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
        Cache::forget('Region');
        $regions = Region::whereIn('id', $request->ids)->get();
        foreach ($regions as $region) {
            Cache::forget('generalPage'.$region->id);
            Cache::forget('statusImageShowPage'.$region->id);
            Cache::forget('mainPdfShowPage'.$region->id);
            Cache::forget('defaultImageShowPage'.$region->id);
            $region->seo()->forceDelete();
            $region->setForceDelete(true);
            $region->images()->detach();
        }

        Region::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
