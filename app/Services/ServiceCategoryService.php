<?php

namespace App\Services;

use App\Contracts\ServiceCategoryInterface;
use App\Http\Requests\ServiceCategory\ServiceCategoryChangeStatusRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryCreateRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryDestroyRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryMassDestroyRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryMassRemoveRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryRemoveRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryRestoreRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryTrashRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryUpdateRequest;
use App\Http\Resources\ServiceCategory\ServiceCategoryResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\ServiceCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\ServiceCategory\ServiceCategoryIndexRequest;

class ServiceCategoryService implements ServiceCategoryInterface
{
    use MenuTrait, ImageUploadTrait, MultiTranslatableTrait;

    public function index(ServiceCategoryIndexRequest $request): LengthAwarePaginator
    {
        return ServiceCategory::select(['id', 'title', 'src', 'created_at', 'status'])
            ->filter($request)
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function getSeoFirst(ServiceCategory $serviceCategory)
    {
        return $serviceCategory->seo()->first();
    }

    public function changeStatus(ServiceCategoryChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('serviceCategories');

        $serviceCategory = ServiceCategory::find($data['id']);

        if (!$serviceCategory) {
            return response()->json([
                'message' => 'ServiceCategory not found',
                'alert-type' => 'error'
            ], 404);
        }

        $serviceCategory->update(['status' => $data['status']]);
        $serviceCategory->setActive($data['status']);

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(ServiceCategoryCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('serviceCategories');

        $serviceCategory = new ServiceCategory();
        $serviceCategory->setMultiTranslations($data);
        $serviceCategory->status = $data['status'];
        $serviceCategory->created_at = $data['published_at'] ?? now();
        $serviceCategory->save();

        $serviceCategory->setSeoTranslations($data);
        $this->processAndSaveImages($data, $serviceCategory, true);
        $serviceCategory->fresh();

        return response()->json([
            'serviceCategory' => ServiceCategoryResource::make($serviceCategory),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(ServiceCategory $serviceCategory): JsonResponse|ServiceCategory
    {
        return $serviceCategory;
    }

    public function edit(ServiceCategory $serviceCategory): ServiceCategory
    {
        return $serviceCategory;
    }

    public function update(serviceCategoryUpdateRequest $request, ServiceCategory $serviceCategory): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('serviceCategories');
        $serviceCategory->setMultiTranslations($data);
        $serviceCategory->status = $data['status'];
        $serviceCategory->created_at = $data['published_at'] ?? now();
        $serviceCategory->save();
        // Set Menu translations if available
        $serviceCategory->setMenuTranslations(
            $serviceCategory->getTranslations('title'),
            $serviceCategory->getTranslations('slug')
        );
        $serviceCategory->setActive($data['status']);
        // Set SEO translations if available
        $serviceCategory->setSeoTranslations($data);
        $this->processAndSaveImages($data, $serviceCategory, true);
        $serviceCategory->fresh();

        return response()->json([
            'serviceCategory' => ServiceCategoryResource::make($serviceCategory),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(ServiceCategoryDestroyRequest $request): JsonResponse
    {
        Cache::forget('serviceCategories');
        $serviceCategory = ServiceCategory::find($request->id);
        if (!$serviceCategory) {
            return response()->json([
                'message' => 'ServiceCategory not found',
                'alert-type' => 'error'
            ], 404);
        }
        $serviceCategory->setActive(false);
        $serviceCategory->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(ServiceCategoryMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('serviceCategories');
        $serviceCategorys = ServiceCategory::whereIn('id', $request->ids)->get();
        foreach ($serviceCategorys as $serviceCategory) {
            $serviceCategory->setActive(false);
        }
        ServiceCategory::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function trash(ServiceCategoryTrashRequest $request): LengthAwarePaginator
    {
        return ServiceCategory::select(['id', 'title', 'created_at'])
            ->filterTrash($request)
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function restore(ServiceCategoryRestoreRequest $request): JsonResponse
    {
        Cache::forget('serviceCategories');
        $serviceCategory = ServiceCategory::where('id', $request->id)->withTrashed()->first();
        $serviceCategory->restore();
        $serviceCategory->setActive(false);
        $serviceCategory->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function remove(ServiceCategoryRemoveRequest $request): JsonResponse
    {
        Cache::forget('serviceCategories');
        $serviceCategoryId = $request->id;
        $data = ServiceCategory::where('id', $serviceCategoryId)->withTrashed()->first();
        $data->seo()->forceDelete();
        $data->images()->detach();
        $data->setForceDelete(true);
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function massRemove(ServiceCategoryMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('serviceCategories');
        $serviceCategorys = ServiceCategory::withTrashed()->whereIn('id', $request->ids)->get();

        foreach ($serviceCategorys as $serviceCategory) {
            $serviceCategory->seo()->forceDelete();
            $serviceCategory->setForceDelete(true);
            $serviceCategory->images()->detach();
        }

        ServiceCategory::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
}
