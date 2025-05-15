<?php

namespace App\Services;

use App\Contracts\SocialInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Requests\Social\SocialCreateRequest;
use App\Http\Requests\Social\SocialUpdateRequest;
use App\Http\Resources\Social\SocialResource;
use App\Models\Social;
use App\Traits\ImageUploadTrait;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SocialService implements SocialInterface
{
    use MenuTrait, ImageUploadTrait, MultiTranslatableTrait;
    const CACHE_TTL = 86400; // 1 day

    public function getSocial()
    {
        if (!Cache::has('Socials')){
            $lang = Cache::remember('Socials', self::CACHE_TTL, function (){
                return Social::orderBy('position','asc')->get();
            });
        }
        return Social::orderBy('position','asc')->get();
    }
    public function changeStatus(ChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Social');

        $social = Social::find($data['id']);
        $social->update(['status' => $data['status']]);

        return  response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(SocialCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Social');
        $social = new Social();
        $social->title = $data['title'];
        $social->icon = $data['icon'];
        $social->link = $data['link'];
        $social->status = $data['status'];
        $social->position = Social::getNextPosition();
        $social->save();
        $social->fresh();

        return response()->json([
            'social' => SocialResource::make($social),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Social $social): JsonResponse|Social
    {
        return $social;
    }

    public function edit(Social $social): Social
    {
        return $social;
    }

    public function update(SocialUpdateRequest $request, Social $social): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Social');
        $social->title = $data['title'];
        $social->icon = $data['icon'];
        $social->link = $data['link'];
        $social->status = $data['status'];
        $social->save();
        $social->fresh();

        return response()->json([
            'social' => SocialResource::make($social),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(Social $social): JsonResponse
    {
        Cache::forget('Social');
        $social->delete();
        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('Social');
        Social::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    public function reorder($request): JsonResponse
    {
        Cache::forget('Social');
        foreach($request->order as $index => $id)
        {
            Social::find($id)->update([
                'position' => $index
            ]);
        }
        return  response()->json([
            'message' =>  __('strings.Position changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    // Archive Function Method
    public function getSocialTrash(): array|Collection
    {
        return Social::onlyTrashed()->get();
    }

    public function restore($id): void
    {
        Cache::forget('Social');
        $social = Social::where('id', $id)->withTrashed()->first();
        $social->restore();
        $social->fresh();
    }

    public function remove($id): JsonResponse
    {
        Cache::forget('Social');
        $social = Social::where('id', $id)->withTrashed()->first();

        $social->forceDelete();
        $social->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 204);
    }

    public function massRemove(MassRemoveRequest $request): JsonResponse
    {
        Cache::forget('Social');
        Social::whereIn('id', $request->ids)->withTrashed()->forceDelete();
        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
