<?php

namespace App\Services;

use App\Contracts\PartnerInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Partner\PartnerCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Partner\PartnerUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Resources\Partner\PartnerResource;
use App\Http\Resources\Partner\PartnersResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Partner;
use Illuminate\Support\Facades\Cache;

class PartnerService implements PartnerInterface
{
    use ImageUploadTrait, MultiTranslatableTrait;
    const CACHE_TTL = 86400; // 1 day

    public function getPartnerPosition()
    {
        return Partner::where('status', 1)->orderBy('position', 'asc')->get();
    }
    public function getPartners()
    {
        if (Cache::has('Partner')){
            $partners = Cache::get('Partner');
        } else {
            $partners = Cache::remember('Partner', self::CACHE_TTL, function (){
                return Partner::all();
            });
        }
        return $partners;
    }
    public function getSeoFirst(Partner $partner)
    {
        return $partner->seo()->first();
    }
    public function changeStatus(ChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Partner');

        $partner = Partner::find($data['id']);
        $partner->update(['status' => $data['status']]);

        return  response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(PartnerCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Partner');

        $partner = new Partner();
        $partner->setMultiTranslations($data);
        $partner->status = $data['status'];
        $partner->url = $data['url'];
        $partner->position = Partner::getNextPosition();
        $partner->save();
        $this->processAndSaveImages($data, $partner);
        $partner->fresh();

        return response()->json([
            'partner' => PartnerResource::make($partner),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Partner $partner): JsonResponse|Partner
    {
        return $partner;
    }

    public function edit(Partner $partner): Partner
    {
        return $partner;
    }

    public function update(PartnerUpdateRequest $request, Partner $partner): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Partner');
        $partner->setMultiTranslations($data);
        $partner->status = $data['status'];
        $partner->url = $data['url'];
        $partner->position = Partner::getNextPosition();
        $partner->save();
        $this->processAndSaveImages($data, $partner);
        $partner->fresh();

        return response()->json([
            'partner' => PartnerResource::make($partner),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(Partner $partner): JsonResponse
    {
        $partner->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('Partner');
        $partners = Partner::whereIn('id', $request->ids);
        $partners->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    public function reorder($data)
    {
        Cache::forget('Partner');
        foreach($data->order as $index => $id)
        {
            Partner::find($id)->update([
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
        Cache::forget('Partner');
        $partner = Partner::where('id', $id)->withTrashed()->first();
        $partner->restore();
        $partner->fresh();
    }

    public function remove($id): JsonResponse
    {
        Cache::forget('Partner');
        $data = Partner::where('id', $id)->withTrashed()->first();
        $data->images()->detach();
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 204);
    }

    public function massRemove(MassRemoveRequest $request): JsonResponse
    {
        Cache::forget('Partner');
        $partners = Partner::whereIn('id', $request->ids)->get();
        foreach ($partners as $partner) {
            $partner->images()->detach();
        }

        Partner::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
