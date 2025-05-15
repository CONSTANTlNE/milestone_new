<?php

namespace App\Services;

use App\Contracts\MediaInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Media\MediaCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Media\MediaUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Resources\Media\MediaResource;
use App\Http\Resources\Media\MediasResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Media;
use Illuminate\Support\Facades\Cache;

class MediaService implements MediaInterface
{
    use ImageUploadTrait, MultiTranslatableTrait;
    const CACHE_TTL = 86400; // 1 day

    public function getMedias()
    {
        if (Cache::has('Media')){
            $medias = Cache::get('Media');
        } else {
            $medias = Cache::remember('Media', self::CACHE_TTL, function (){
                return Media::all();
            });
        }
        return $medias;
    }

    public function changeStatus(ChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Media');

        $media = Media::find($data['id']);
        $media->update(['status' => $data['status']]);

        return  response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(MediaCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Media');

        $media = new Media();
        $media->setMultiTranslations($data);
        $media->status = $data['status'];
        $media->position = Media::getNextPosition();
        $media->created_at = $request->published_at ?? now();
        $media->save();
        $this->processAndSaveImages($data, $media);
        $media->fresh();

        return response()->json([
            'media' => MediaResource::make($media),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Media $media): JsonResponse|Media
    {
        return $media;
    }

    public function edit(Media $media): Media
    {
        return $media;
    }

    public function update(MediaUpdateRequest $request, Media $media): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Media');
        $media->setMultiTranslations($data);
        $media->status = $data['status'];
        $media->position = Media::getNextPosition();
        $media->created_at = $request->published_at ?? now();
        $media->save();
        $this->processAndSaveImages($data, $media);
        $media->fresh();

        return response()->json([
            'media' => MediaResource::make($media),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(Media $media): JsonResponse
    {
        $media->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('Media');
        $medias = Media::whereIn('id', $request->ids);
        $medias->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function restore($id): void
    {
        Cache::forget('Media');
        $media = Media::where('id', $id)->withTrashed()->first();
        $media->restore();
        $media->fresh();
    }

    public function remove($id): JsonResponse
    {
        Cache::forget('Media');
        $data = Media::where('id', $id)->withTrashed()->first();
        $data->images()->detach();
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 204);
    }

    public function massRemove(MassRemoveRequest $request): JsonResponse
    {
        Cache::forget('Media');
        $medias = Media::whereIn('id', $request->ids)->get();
        foreach ($medias as $media) {
            $media->images()->detach();
        }

        Media::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
