<?php

namespace App\Services;

use App\Contracts\LocaleInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Requests\Locale\LocaleCreateRequest;
use App\Http\Requests\Locale\LocaleUpdateRequest;
use App\Http\Resources\Locale\LocaleResource;
use App\Models\Locale;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use App\Traits\CacheableTrait;

class LocaleService implements LocaleInterface
{
    use CacheableTrait, ImageUploadTrait;
    const CACHE_TTL = 86400; // 1 day

    public function getLocales()
    {
        if (!Cache::has('locales')){
            Cache::remember('locales', self::CACHE_TTL, function (){
                return Locale::select('id', 'name', 'native', 'code', 'status', 'default')
                    ->where('status', '1')
                    ->with('generalImage')
                    ->orderBy('position', 'asc')
                    ->get();
            });
        }

        return Cache::get('locales');
    }

    public function changeStatus(Locale $locale): JsonResponse
    {
        $status = $locale->status == 0 ? 1 : 0;
        $locale->update(['status' => $status]);
        $locale->load('generalImage');
        $this->updateCachedCollection('locales', $locale, self::CACHE_TTL);

        return  response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function general(Locale $locale): Locale
    {
        Cache::forget('locales');
        $localeGeneral = Locale::where('default', 1)->first();
        $localeGeneral->default = 0;
        $localeGeneral->save();
        $locale->default = $locale->default == 0 ? 1 : 0;
        $locale->status = 1;
        $locale->save();
        return $locale;
    }

    public function store(LocaleCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $locale = Locale::create([
            'name' => $data['name'],
            'code' => $data['code'],
            'status' => $data['status'],
            'default' => 0,
            'position' => Locale::getNextPosition(),
        ]);
        $this->processAndSaveImages($data, $locale);
        $locale->load('generalImage');
        $this->addToCacheCollection('locales', $locale, self::CACHE_TTL);

        return response()->json([
            'locale' => LocaleResource::make($locale),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Locale $locale): JsonResponse|Locale
    {
        return $locale;
    }

    public function edit(Locale $locale): Locale
    {
        return $locale;
    }

    public function update(LocaleUpdateRequest $request, Locale $locale): JsonResponse
    {
        $data = $request->validated();
        $locale->update([
            'name' => $data['name'],
            'code' => $data['code'],
            'status' => $data['status'],
            'default' => 0,
            'position' => Locale::getNextPosition(),
        ]);
        $this->processAndSaveImages($data, $locale);
        $locale->load('generalImage');
        $this->updateCachedCollection('locales', $locale, self::CACHE_TTL);
        return response()->json([
            'locale' => LocaleResource::make($locale),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(Locale $locale): JsonResponse
    {
        $this->deleteCachedCollection('locales', $locale->id, self::CACHE_TTL);
        $locale->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('locales');
        Locale::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    public function reorder($request): JsonResponse
    {
        Cache::forget('locales');
        foreach($request->order as $index => $id)
        {
            Locale::find($id)->update([
                'position' => $index
            ]);
        }
        return  response()->json([
            'message' =>  __('strings.Position changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    // Archive Function Method
    public function getLocaleTrash(): array|Collection
    {
         return Locale::onlyTrashed()
              ->with('generalImage')
              ->get();
    }

    public function restore($id): void
    {
        Cache::forget('locales');
        $locale = Locale::where('id', $id)->withTrashed()->first();
        $locale->restore();
        $locale->fresh();
    }

    public function remove($id): JsonResponse
    {
        $locale = Locale::where('id', $id)->withTrashed()->first();
        $locale->forceDelete();
        $locale->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 204);
    }

    public function massRemove(MassRemoveRequest $request): JsonResponse
    {
        Locale::whereIn('id', $request->ids)->withTrashed()->forceDelete();
        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
