<?php

namespace App\Services;

use App\Contracts\DataInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Data\DataCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Data\DataUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Resources\Data\DataResource;
use App\Http\Resources\Data\DatasResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Data;
use Illuminate\Support\Facades\Cache;

class DataService implements DataInterface
{
    use ImageUploadTrait, MultiTranslatableTrait;
    const CACHE_TTL = 86400; // 1 day

    public function getData()
    {
        if (Cache::has('Data')){
            $datas = Cache::get('Data');
        } else {
            $datas = Cache::remember('Data', self::CACHE_TTL, function (){
                return Data::all();
            });
        }
        return $datas;
    }
    public function getSeoFirst(Data $data)
    {
        return $data->seo()->first();
    }
    public function changeStatus(ChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Data');

        $d = Data::find($data['id']);
        $d->update(['status' => $data['status']]);

        return  response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(DataCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Data');

        $d = new Data();
        $d->setMultiTranslations($data);
        $d->status = $data['status'];
        $d->save();
        // Set SEO translations if available
        $d->setSeoTranslations($data);
        $this->processAndSaveImages($data, $d);
        $d->fresh();

        return response()->json([
            'data' => DataResource::make($d),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Data $data): JsonResponse|Data
    {
        return $data;
    }

    public function edit(Data $data): Data
    {
        return $data;
    }

    public function update(DataUpdateRequest $request, Data $d): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Data');
        $d->setMultiTranslations($data);
        $d->status = $data['status'];
        $d->save();
        // Set SEO translations if available
        $d->setSeoTranslations($data);
        $this->processAndSaveImages($data, $d);
        $d->fresh();

        return response()->json([
            'data' => DataResource::make($d),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(Data $data): JsonResponse
    {
        $data->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('Data');
        $datas = Data::whereIn('id', $request->ids);
        $datas->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function restore($id): void
    {
        Cache::forget('Data');
        $data = Data::where('id', $id)->withTrashed()->first();
        $data->restore();
        $data->fresh();
    }

    public function remove($id): JsonResponse
    {
        Cache::forget('Data');
        Cache::forget('generalData'.$id);
        Cache::forget('statusImageShowData'.$id);
        Cache::forget('mainPdfShowData'.$id);
        Cache::forget('defaultImageShowData'.$id);
        $data = Data::where('id', $id)->withTrashed()->first();
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
        Cache::forget('Data');
        $datas = Data::whereIn('id', $request->ids)->get();
        foreach ($datas as $data) {
            Cache::forget('generalData'.$data->id);
            Cache::forget('statusImageShowData'.$data->id);
            Cache::forget('mainPdfShowData'.$data->id);
            Cache::forget('defaultImageShowData'.$data->id);
            $data->seo()->forceDelete();
            $data->images()->detach();
        }

        Data::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
