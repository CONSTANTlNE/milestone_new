<?php

namespace App\Services;

use App\Contracts\SliderInterface;
use App\Http\Requests\Slider\SliderChangeStatusRequest;
use App\Http\Requests\Slider\SliderCreateRequest;
use App\Http\Requests\Slider\SliderDestroyRequest;
use App\Http\Requests\Slider\SliderMassDestroyRequest;
use App\Http\Requests\Slider\SliderMassRemoveRequest;
use App\Http\Requests\Slider\SliderRemoveRequest;
use App\Http\Requests\Slider\SliderRestoreRequest;
use App\Http\Requests\Slider\SliderTrashRequest;
use App\Http\Requests\Slider\SliderUpdateRequest;
use App\Http\Resources\Slider\SliderResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Slider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Slider\SliderIndexRequest;

class SliderService implements SliderInterface
{
    use ImageUploadTrait, MultiTranslatableTrait;

    public function index(SliderIndexRequest $request): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        return Slider::query()
            ->when($request->filled('search'), function ($query) use ($request, $locale) {
                $search = $request->search;
                $query->where(function ($q) use ($search, $locale) {
                    $q->whereRaw('CAST(id AS TEXT) ILIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw("title->>? ILIKE ?", [$locale, '%' . $search . '%']);
                });
            })
            ->when($request->filled('status') && $request->status !== 'all', function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when(
                $request->filled('sort_column'),
                function ($q) use ($request) {
                    $q->orderBy(
                        $request->input('sort_column'),
                        $request->input('sort_direction', 'asc')
                    );
                },
                function ($q) {
                    $q->orderBy('position', 'asc');
                }
            )
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }


    public function changeStatus(SliderChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('sliders');

        $slider = Slider::find($data['id']);

        if (!$slider) {
            return response()->json([
                'message' => 'Slider not found',
                'alert-type' => 'error'
            ], 404);
        }

        $slider->update(['status' => $data['status']]);

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(SliderCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('sliders');

        $slider = new Slider();
        $slider->setMultiTranslations($data);
        $slider->status = $data['status'];
        $slider->position = Slider::getNextPosition();
        $slider->created_at = $data['published_at'] ?? now();
        $slider->save();

        $this->processAndSaveImages($data, $slider, true);
        $slider->fresh();

        return response()->json([
            'slider' => SliderResource::make($slider),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Slider $slider): JsonResponse|Slider
    {
        return $slider;
    }

    public function edit(Slider $slider): Slider
    {
        return $slider;
    }

    public function update(SliderUpdateRequest $request, Slider $slider): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('sliders');
        $slider->setMultiTranslations($data);
        $slider->status = $data['status'];
        $slider->created_at = $data['published_at'] ?? now();
        $slider->save();
        $this->processAndSaveImages($data, $slider, true);
        $slider->fresh();

        return response()->json([
            'slider' => SliderResource::make($slider),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(SliderDestroyRequest $request): JsonResponse
    {
        Cache::forget('sliders');
        $slider = Slider::find($request->id);
        if (!$slider) {
            return response()->json([
                'message' => 'Slider not found',
                'alert-type' => 'error'
            ], 404);
        }
        $slider->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(SliderMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('sliders');

        Slider::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    public function reorder($request): JsonResponse
    {
        Cache::forget('sliders');
        foreach($request->order as $index => $id)
        {
            Slider::find($id)->update([
                'position' => $index
            ]);
        }
        return  response()->json([
            'message' =>  __('strings.Position changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    // Archive Function Method
    public function trash(SliderTrashRequest $request): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        return Slider::onlyTrashed()
            ->when($request->filled('search'), function ($query) use ($request, $locale) {
                $search = $request->search;
                $query->where(function ($q) use ($search, $locale) {
                    $q->whereRaw('CAST(id AS TEXT) ILIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw("title->>? ILIKE ?", [$locale, '%' . $search . '%']);
                });
            })
            ->orderBy(
                $request->input('sort_column', 'id'),
                $request->input('sort_direction', 'desc')
            )
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function restore(SliderRestoreRequest $request): JsonResponse
    {
        Cache::forget('sliders');
        $slider = Slider::where('id', $request->id)->withTrashed()->first();
        $slider->restore();
        $slider->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function remove(SliderRemoveRequest $request): JsonResponse
    {
        Cache::forget('sliders');
        $sliderId = $request->id;
        $data = Slider::where('id', $sliderId)->withTrashed()->first();
        $data->images()->detach();
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function massRemove(SliderMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('sliders');
        $sliders = Slider::withTrashed()->whereIn('id', $request->ids)->get();

        foreach ($sliders as $slider) {
            $slider->images()->detach();
        }

        Slider::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
}
