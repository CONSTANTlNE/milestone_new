<?php

namespace App\Services;

use App\Contracts\FaqInterface;
use App\Http\Requests\Faq\FaqChangeStatusRequest;
use App\Http\Requests\Faq\FaqCreateRequest;
use App\Http\Requests\Faq\FaqDestroyRequest;
use App\Http\Requests\Faq\FaqMassDestroyRequest;
use App\Http\Requests\Faq\FaqMassRemoveRequest;
use App\Http\Requests\Faq\FaqRemoveRequest;
use App\Http\Requests\Faq\FaqRestoreRequest;
use App\Http\Requests\Faq\FaqTrashRequest;
use App\Http\Requests\Faq\FaqUpdateRequest;
use App\Http\Resources\Faq\FaqResource;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Faq;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Faq\FaqIndexRequest;

class FaqService implements FaqInterface
{
    use MultiTranslatableTrait;

    public function index(FaqIndexRequest $request): LengthAwarePaginator
    {
        return Faq::select(['id', 'title', 'service_id', 'created_at', 'status'])
            ->with(['service'])
            ->filter($request)
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function changeStatus(FaqChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('faqs');

        $faq = Faq::find($data['id']);

        if (!$faq) {
            return response()->json([
                'message' => 'Faq not found',
                'alert-type' => 'error'
            ], 404);
        }

        $faq->update(['status' => $data['status']]);

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(FaqCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('faqs');

        $faq = new Faq();
        $faq->setMultiTranslations($data);
        $faq->status = $data['status'];
        $faq->created_at = $data['published_at'] ?? now();
        $faq->save();
        $faq->fresh();

        return response()->json([
            'faq' => FaqResource::make($faq),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Faq $faq): JsonResponse|Faq
    {
        return $faq;
    }

    public function edit(Faq $faq): Faq
    {
        return $faq;
    }

    public function update(FaqUpdateRequest $request, Faq $faq): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('faqs');
        $faq->setMultiTranslations($data);
        $faq->status = $data['status'];
        $faq->created_at = $data['published_at'] ?? now();
        $faq->save();
        $faq->fresh();

        return response()->json([
            'faq' => FaqResource::make($faq),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(FaqDestroyRequest $request): JsonResponse
    {
        Cache::forget('faqs');
        $faq = Faq::find($request->id);
        if (!$faq) {
            return response()->json([
                'message' => 'Faq not found',
                'alert-type' => 'error'
            ], 404);
        }
        $faq->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(FaqMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('faqs');
        Faq::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function trash(FaqTrashRequest $request): LengthAwarePaginator
    {
        return Faq::select(['id', 'title', 'created_at'])
            ->filterTrash($request)
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function restore(FaqRestoreRequest $request): JsonResponse
    {
        Cache::forget('faqs');
        $faq = Faq::where('id', $request->id)->withTrashed()->first();
        $faq->restore();
        $faq->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function remove(FaqRemoveRequest $request): JsonResponse
    {
        Cache::forget('faqs');
        $faqId = $request->id;
        $data = Faq::where('id', $faqId)->withTrashed()->first();
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function massRemove(FaqMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('faqs');

        Faq::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
}
