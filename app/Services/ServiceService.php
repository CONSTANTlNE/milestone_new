<?php

namespace App\Services;

use App\Contracts\ServiceInterface;
use App\Http\Requests\Service\ServiceChangeStatusRequest;
use App\Http\Requests\Service\ServiceCreateRequest;
use App\Http\Requests\Service\ServiceDestroyRequest;
use App\Http\Requests\Service\ServiceMassDestroyRequest;
use App\Http\Requests\Service\ServiceMassRemoveRequest;
use App\Http\Requests\Service\ServiceRemoveRequest;
use App\Http\Requests\Service\ServiceRestoreRequest;
use App\Http\Requests\Service\ServiceTrashRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Http\Resources\Service\ServiceResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Service;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Service\ServiceIndexRequest;
use Illuminate\Support\Str;

class ServiceService implements ServiceInterface
{
    use ImageUploadTrait, MultiTranslatableTrait;

    public function index(ServiceIndexRequest $request): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        return Service::query()
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
            ->orderBy(
                $request->input('sort_column', 'id'),
                $request->input('sort_direction', 'desc')
            )
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function getSeoFirst(Service $service)
    {
        return $service->seo()->first();
    }

    public function changeStatus(ServiceChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('services');

        $service = Service::find($data['id']);

        if (!$service) {
            return response()->json([
                'message' => 'Service not found',
                'alert-type' => 'error'
            ], 404);
        }

        $service->update(['status' => $data['status']]);

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(ServiceCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('services');

        $service = new Service();
        $service->setMultiTranslations($data);
        $service->status = $data['status'];
        $service->created_at = $data['published_at'] ?? now();
        $service->save();

        if (isset($data['category'])) {
            $service->categories()->sync($data['category']);
        }

        // Save features with translations using a private function, only if data exists
        $locales = array_keys(json_decode(file_get_contents(lang_path('config_locales.json')), true));
        $hasFeatures = false;
        $hasFaqs = false;

        foreach ($locales as $locale) {
            if (!empty($request->input("service_feature_name_{$locale}", []))) {
                $hasFeatures = true;
                break;
            }
        }

        foreach ($locales as $locale) {
            if (!empty($request->input("faq_question_{$locale}", []))) {
                $hasFaqs = true;
                break;
            }
        }

        if ($hasFeatures) {
            $this->saveServiceFeatures($request, $service, $locales);
        }

        if ($hasFaqs) {
            $this->saveServiceFaqs($request, $service, $locales);
        }

        $service->setSeoTranslations($data);
        $this->processAndSaveImages($data, $service, true);
        $service->fresh();

        return response()->json([
            'service' => ServiceResource::make($service),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    /**
     * Save service features with translations from request
     *
     * @param $request
     * @param Service $service
     * @return void
     */
    private function saveServiceFeatures($request, Service $service, array $locales): void
    {
        $featureNames = [];
        foreach ($locales as $locale) {
            $featureNames[$locale] = $request->input("service_feature_name_{$locale}", []);
        }
        $featureCount = count($featureNames[$locales[0]] ?? []);
        for ($i = 0; $i < $featureCount; $i++) {
            $translations = [];
            foreach ($locales as $locale) {
                $translations[$locale] = $featureNames[$locale][$i] ?? '';
            }
            $service->features()->create([
                'title' => $translations,
                'service_id' => $service->id,
            ]);
        }
    }

    private function saveServiceFaqs($request, Service $service, array $locales): void
    {
        $questions = [];
        $answers = [];
        foreach ($locales as $locale) {
            $questions[$locale] = $request->input("faq_question_{$locale}", []);
            $answers[$locale] = $request->input("faq_answer_{$locale}", []);
        }
        $faqCount = count($questions[$locales[0]] ?? []);
        for ($i = 0; $i < $faqCount; $i++) {
            $questionTranslations = [];
            $answerTranslations = [];
            $slugTranslations = [];
            foreach ($locales as $locale) {
                $questionTranslations[$locale] = $questions[$locale][$i] ?? '';
                $slugTranslations[$locale] = Str::slug((string)$questions[$locale][$i]) ?? '';
                $answerTranslations[$locale] = $answers[$locale][$i] ?? '';
            }
            $service->faqs()->create([
                'title' => $questionTranslations,
                'slug' => $slugTranslations,
                'content' => $answerTranslations,
                'service_id' => $service->id,
            ]);
        }
    }

    public function show(Service $service): JsonResponse|Service
    {
        return $service;
    }

    public function edit(Service $service): Service
    {
        return $service;
    }

    public function update(ServiceUpdateRequest $request, Service $service): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('services');
        $service->setMultiTranslations($data);
        $service->status = $data['status'];
        $service->created_at = $data['published_at'] ?? now();
        $service->save();

        if (isset($data['category'])) {
            $service->categories()->sync($data['category']);
        }else{
            $service->categories()->detach();
        }

        // Save features with translations using a private function, only if data exists
        $locales = array_keys(json_decode(file_get_contents(lang_path('config_locales.json')), true));
        $hasFeatures = false;
        $hasFaqs = false;

        foreach ($locales as $locale) {
            if (!empty($request->input("service_feature_name_{$locale}", []))) {
                $hasFeatures = true;
                break;
            }
        }

        foreach ($locales as $locale) {
            if (!empty($request->input("faq_question_{$locale}", []))) {
                $hasFaqs = true;
                break;
            }
        }

        // Clear existing features and FAQs before adding new ones
        if ($hasFeatures) {
            $service->features()->delete();
            $this->saveServiceFeatures($request, $service, $locales);
        }

        if ($hasFaqs) {
            $service->faqs()->forceDelete();
            $this->saveServiceFaqs($request, $service, $locales);
        }

        // Set SEO translations if available
        $service->setSeoTranslations($data);
        $this->processAndSaveImages($data, $service, true);
        $service->fresh();

        return response()->json([
            'service' => ServiceResource::make($service),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(ServiceDestroyRequest $request): JsonResponse
    {
        Cache::forget('services');
        $service = Service::find($request->id);
        if (!$service) {
            return response()->json([
                'message' => 'Service not found',
                'alert-type' => 'error'
            ], 404);
        }
        $service->faqs()->delete();
        $service->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(ServiceMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('services');
        $services = Service::whereIn('id', $request->ids)->get();
        foreach ($services as $service) {
            $service->faqs()->delete();
        }
        Service::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function trash(ServiceTrashRequest $request): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        return Service::onlyTrashed()
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

    public function restore(ServiceRestoreRequest $request): JsonResponse
    {
        Cache::forget('services');
        $service = Service::where('id', $request->id)->withTrashed()->first();
        $service->faqs()->restore();
        $service->restore();
        $service->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function remove(ServiceRemoveRequest $request): JsonResponse
    {
        Cache::forget('services');
        $serviceId = $request->id;
        $data = Service::where('id', $serviceId)->withTrashed()->first();
        $data->seo()->forceDelete();
        $data->images()->detach();
        $data->faqs()->forceDelete();
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function massRemove(ServiceMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('services');
        $services = Service::withTrashed()->whereIn('id', $request->ids)->get();

        foreach ($services as $service) {
            $service->seo()->forceDelete();
            $service->images()->detach();
            $service->faqs()->forceDelete();
        }

        Service::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
}
