<?php

namespace App\Services;

use App\Contracts\BannerInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Banner\BannerCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Banner\BannerUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Resources\Banner\BannerResource;
use App\Http\Resources\Banner\BannersResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Banner;
use Illuminate\Support\Facades\Cache;

class BannerService implements BannerInterface
{
    use ImageUploadTrait, MultiTranslatableTrait;
    const CACHE_TTL = 86400; // 1 day

    public function getBannerPosition()
    {
        return Banner::where('status', 1)->orderBy('position', 'asc')->get();
    }
    public function getBanners()
    {
        if (Cache::has('Banner')){
            $banners = Cache::get('Banner');
        } else {
            $banners = Cache::remember('Banner', self::CACHE_TTL, function (){
                return Banner::all();
            });
        }
        return $banners;
    }
    public function getSeoFirst(Banner $banner)
    {
        return $banner->seo()->first();
    }
    public function changeStatus(ChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Banner');

        $banner = Banner::find($data['id']);
        $banner->update(['status' => $data['status']]);

        return  response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(BannerCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Banner');

        $banner = new Banner();
        $banner->setMultiTranslations($data);
        $banner->status = $data['status'];
        $banner->url = $data['url'];
        $banner->zone = $data['zone'];
        $banner->position = Banner::getNextPosition();
        $banner->save();
        $this->processAndSaveImages($data, $banner);
        $banner->fresh();

        return response()->json([
            'banner' => BannerResource::make($banner),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Banner $banner): JsonResponse|Banner
    {
        return $banner;
    }

    public function edit(Banner $banner): Banner
    {
        return $banner;
    }

    public function update(BannerUpdateRequest $request, Banner $banner): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Banner');
        $banner->setMultiTranslations($data);
        $banner->status = $data['status'];
        $banner->url = $data['url'];
        $banner->zone = $data['zone'];
        $banner->position = Banner::getNextPosition();
        $banner->save();
        $this->processAndSaveImages($data, $banner);
        $banner->fresh();

        return response()->json([
            'banner' => BannerResource::make($banner),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(Banner $banner): JsonResponse
    {
        $banner->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('Banner');
        $banners = Banner::whereIn('id', $request->ids);
        $banners->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    public function reorder($request)
    {
        Cache::forget('Banner');
        foreach($request->order as $index => $id)
        {
            Banner::find($id)->update([
                'position' => $index
            ]);
        }
        return  response()->json([
            'message' =>  __('strings.Position changed successfully'),
            'alert-type' => 'success'
        ]);
    }
    // Archive Function Method
    public function restore($id): void
    {
        Cache::forget('Banner');
        $banner = Banner::where('id', $id)->withTrashed()->first();
        $banner->restore();
        $banner->fresh();
    }

    public function remove($id): JsonResponse
    {
        Cache::forget('Banner');
        $data = Banner::where('id', $id)->withTrashed()->first();
        $data->seo()->forceDelete();
        $data->images()->detach();
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 204);
    }

    public function massRemove(MassRemoveRequest $request): JsonResponse
    {
        Cache::forget('Banner');
        $banners = Banner::whereIn('id', $request->ids)->get();
        foreach ($banners as $banner) {
            $banner->seo()->forceDelete();
            $banner->images()->detach();
        }

        Banner::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
