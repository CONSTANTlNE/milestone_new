<?php

namespace App\Services;

use App\Contracts\LocaleInterface;
use App\Http\Requests\Locale\LocaleChangeStatusRequest;
use App\Http\Requests\Locale\LocaleCreateRequest;
use App\Http\Requests\Locale\LocaleDestroyRequest;
use App\Http\Requests\Locale\LocaleMassDestroyRequest;
use App\Http\Requests\Locale\LocaleMassRemoveRequest;
use App\Http\Requests\Locale\LocaleRemoveRequest;
use App\Http\Requests\Locale\LocaleRestoreRequest;
use App\Http\Requests\Locale\LocaleTrashRequest;
use App\Http\Requests\Locale\LocaleUpdateRequest;
use App\Http\Requests\Social\SocialCreateRequest;
use App\Http\Resources\Locale\LocaleResource;
use App\Http\Resources\Social\SocialResource;
use App\Models\Social;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Locale;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Locale\LocaleIndexRequest;
use App\Traits\LocaleJsonSyncTrait;

class LocaleService implements LocaleInterface
{
    use ImageUploadTrait, LocaleJsonSyncTrait;
    const CACHE_TTL = 86400; // 1 day

    public function index(LocaleIndexRequest $request): LengthAwarePaginator
    {
        return Locale::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('CAST(id AS TEXT) ILIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw("title ILIKE ?", ['%' . $search . '%']);
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

    public function changeStatus(LocaleChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('locales');

        $locale = Locale::find($data['id']);

        if (!$locale) {
            return response()->json([
                'message' => 'Social not found',
                'alert-type' => 'error'
            ], 404);
        }

        $locale->update(['status' => $data['status']]);
        $locale->save();
        $this->updateLocalesJsonFile();

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }


    public function store(LocaleCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('locales');
        $this->createLanguageJsonFile($data['code']);
        $locale = Locale::create([
            'title' => $data['title'],
            'code' => $data['code'],
            'status' => $data['status'],
            'position' => Locale::getNextPosition(),
        ]);
        $this->processAndSaveImages($data, $locale, true);
        $locale->load('generalImage');
        $this->updateLocalesJsonFile();
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
        Cache::forget('locales');
        $locale->update([
            'title' => $data['title'],
            'code' => $data['code'],
            'status' => $data['status']
        ]);
        $this->processAndSaveImages($data, $locale, true);
        $locale->load('generalImage');
        $this->updateLocalesJsonFile();
        return response()->json([
            'locale' => LocaleResource::make($locale),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(LocaleDestroyRequest $request): JsonResponse
    {
        Cache::forget('locales');
        $locale = Locale::find($request->id);
        if (!$locale) {
            return response()->json([
                'message' => 'Locale not found',
                'alert-type' => 'error'
            ], 404);
        }
        $locale->delete();
        $this->updateLocalesJsonFile();


        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(LocaleMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('locales');
        Locale::whereIn('id', $request->ids)->delete();
        $this->updateLocalesJsonFile();
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
        $this->updateLocalesJsonFile();
        return  response()->json([
            'message' =>  __('strings.Position changed successfully'),
            'alert-type' => 'success'
        ]);
    }


    // Archive Function Method
    public function trash(LocaleTrashRequest $request): LengthAwarePaginator
    {
        return Locale::onlyTrashed()
            ->with('generalImage')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('CAST(id AS TEXT) ILIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw("title ILIKE ?", ['%' . $search . '%']);
                });
            })
            ->orderBy(
                $request->input('sort_column', 'id'),
                $request->input('sort_direction', 'desc')
            )
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function restore(LocaleRestoreRequest $request): JsonResponse
    {
        Cache::forget('locales');
        $locale = Locale::where('id', $request->id)->withTrashed()->first();
        $locale->restore();
        $locale->fresh();
        $this->updateLocalesJsonFile();
        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
    public function remove(LocaleRemoveRequest $request): JsonResponse
    {
        Cache::forget('locales');
        $data = Locale::where('id', $request->id)->withTrashed()->first();
        $this->deleteLanguageJsonFile($data->code);
        $data->forceDelete();
        $data->fresh();
        $this->updateLocalesJsonFile();
        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
    public function massRemove(LocaleMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('locales');
        $locales = Locale::withTrashed()->whereIn('id', $request->ids)->get();

        foreach ($locales as $locale) {
            $this->deleteLanguageJsonFile($locale->code);
        }

        Locale::whereIn('id', $request->ids)->withTrashed()->forceDelete();
        $this->updateLocalesJsonFile();
        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Create a language JSON file in the lang directory for the given code and title.
     */
    private function createLanguageJsonFile(string $code): void
    {
        $langPath = base_path('lang/' . $code . '.json');
        if (!file_exists($langPath)) {
            file_put_contents($langPath, json_encode(new \stdClass(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
    }

    /**
     * Delete a language JSON file in the lang directory for the given code.
     */
    private function deleteLanguageJsonFile(string $code): void
    {
        $langPath = base_path('lang/' . $code . '.json');
        if (file_exists($langPath)) {
            unlink($langPath);
        }
    }
}
