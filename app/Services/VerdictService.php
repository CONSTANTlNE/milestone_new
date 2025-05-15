<?php

namespace App\Services;

use App\Contracts\VerdictInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\RewriteRequest;
use App\Http\Requests\Verdict\VerdictCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Verdict\VerdictUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Verdict\VerdictResource;
use App\Http\Resources\Verdict\VerdictsResource;
use App\Models\Article;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Verdict;
use Illuminate\Support\Facades\Cache;

class VerdictService implements VerdictInterface
{
    use MenuTrait, MultiTranslatableTrait;
    const CACHE_TTL = 86400; // 1 day
    public function getVerdicts()
    {
        return Verdict::where('parent_id', '!=', null)->pluck('title', 'id');
    }

    public function rewriteVerdict(RewriteRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Verdict');
        Cache::forget('Article');

        Article::where('verdict_id', $data['firstId'])->update(['verdict_id' => $data['secondId']]);

        return response()->json([
            'message' => __('strings.Rewrite Successfully')
        ], 201);
    }

    public function getVerdictsParent()
    {
        return Verdict::where('parent_id', null)->where('status', 1)->get();
    }
    public function getSeoFirst(Verdict $verdict)
    {
        return $verdict->seo()->first();
    }
    public function changeStatus(ChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Verdict');

        $verdict = Verdict::find($data['id']);
        $verdict->update(['status' => $data['status']]);

        $verdict->setActive($data['status']);

        return  response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(VerdictCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Verdict');

        $verdict = new Verdict();
        $verdict->setMultiTranslations($data);
        $verdict->status = $data['status'];
        $verdict->color = $data['color'] ?? 0;
        $verdict->colorCode = $data['colorCode'] ?? "#ff0000";
        if($data['parent_id']){
            $verdict->parent_id = $data['parent_id'];
        }
        $verdict->position = Verdict::getNextPosition();
        $verdict->save();
        // Set SEO translations if available
        $verdict->setSeoTranslations($data);
        $verdict->fresh();

        return response()->json([
            'verdict' => VerdictResource::make($verdict),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Verdict $verdict): JsonResponse|Verdict
    {
        return $verdict;
    }

    public function edit(Verdict $verdict): Verdict
    {
        return $verdict;
    }

    public function update(VerdictUpdateRequest $request, Verdict $verdict): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Verdict');
        $verdict->setMultiTranslations($data);
        $verdict->status = $data['status'];
        $verdict->color = $data['color'];
        $verdict->colorCode = $data['colorCode'] ?? "#ff0000";
        if($data['parent_id']){
            $verdict->parent_id = $data['parent_id'];
        }
        $verdict->position = Verdict::getNextPosition();
        $verdict->save();
        // Set Menu translations if available
        $verdict->setMenuTranslations(
            $verdict->getTranslations('title'),
            $verdict->getTranslations('slug')
        );
        $verdict->setActive($data['status']);
        // Set SEO translations if available
        $verdict->setSeoTranslations($data);
        $verdict->fresh();

        return response()->json([
            'verdict' => VerdictResource::make($verdict),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(Verdict $verdict): JsonResponse
    {
        $verdict->setActive(false);
        $verdict->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('Verdict');
        $verdicts = Verdict::whereIn('id', $request->ids);
        foreach ($verdicts as $verdict) {
            $verdict->setActive(false);
        }
        $verdicts->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function restore($id): void
    {
        Cache::forget('Verdict');
        $verdict = Verdict::where('id', $id)->withTrashed()->first();
        $verdict->restore();
        $verdict->setActive(false);
        $verdict->fresh();
    }

    public function remove($id): JsonResponse
    {
        Cache::forget('Verdict');
        $data = Verdict::where('id', $id)->withTrashed()->first();
        $data->seo()->forceDelete();
        $data->images()->detach();
        $data->setForceDelete(true);
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 204);
    }

    public function massRemove($id): JsonResponse
    {
        Cache::forget('Verdict');
        $verdicts = Verdict::whereIn('id', $id)->get();
        foreach ($verdicts as $verdict) {
            $verdict->seo()->forceDelete();
            $verdict->setForceDelete(true);
            $verdict->images()->detach();
        }

        Verdict::whereIn('id', $id)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
