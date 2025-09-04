<?php

namespace App\Services;

use App\Contracts\PortfolioInterface;
use App\Http\Requests\Portfolio\PortfolioChangeStatusRequest;
use App\Http\Requests\Portfolio\PortfolioCreateRequest;
use App\Http\Requests\Portfolio\PortfolioDestroyRequest;
use App\Http\Requests\Portfolio\PortfolioMassDestroyRequest;
use App\Http\Requests\Portfolio\PortfolioMassRemoveRequest;
use App\Http\Requests\Portfolio\PortfolioRemoveRequest;
use App\Http\Requests\Portfolio\PortfolioRestoreRequest;
use App\Http\Requests\Portfolio\PortfolioTrashRequest;
use App\Http\Requests\Portfolio\PortfolioUpdateRequest;
use App\Http\Resources\Portfolio\PortfolioResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Portfolio;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Portfolio\PortfolioIndexRequest;

class PortfolioService implements PortfolioInterface
{
    use ImageUploadTrait, MultiTranslatableTrait;

    public function index(PortfolioIndexRequest $request): LengthAwarePaginator
    {
        return Portfolio::select(['id', 'title', 'src', 'created_at', 'status'])
            ->filter($request)
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function getSeoFirst(Portfolio $portfolio)
    {
        return $portfolio->seo()->first();
    }

    public function changeStatus(PortfolioChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('portfolios');

        $portfolio = Portfolio::find($data['id']);

        if (!$portfolio) {
            return response()->json([
                'message' => 'Portfolio not found',
                'alert-type' => 'error'
            ], 404);
        }

        $portfolio->update(['status' => $data['status']]);

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(PortfolioCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('portfolios');

        $portfolio = new Portfolio();
        $portfolio->setMultiTranslations($data);
        $portfolio->status = $data['status'];
        $portfolio->created_at = $data['published_at'] ?? now();
        $portfolio->save();

        $portfolio->setSeoTranslations($data);
        $this->processAndSaveImages($data, $portfolio, true);
        $portfolio->fresh();

        return response()->json([
            'portfolio' => PortfolioResource::make($portfolio),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Portfolio $portfolio): JsonResponse|Portfolio
    {
        return $portfolio;
    }

    public function edit(Portfolio $portfolio): Portfolio
    {
        return $portfolio;
    }

    public function update(PortfolioUpdateRequest $request, Portfolio $portfolio): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('portfolios');
        $portfolio->setMultiTranslations($data);
        $portfolio->status = $data['status'];
        $portfolio->created_at = $data['published_at'] ?? now();
        $portfolio->save();
        // Set SEO translations if available
        $portfolio->setSeoTranslations($data);
        $this->processAndSaveImages($data, $portfolio, true);
        $portfolio->fresh();

        return response()->json([
            'portfolio' => PortfolioResource::make($portfolio),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(PortfolioDestroyRequest $request): JsonResponse
    {
        Cache::forget('portfolios');
        $portfolio = Portfolio::find($request->id);
        if (!$portfolio) {
            return response()->json([
                'message' => 'Portfolio not found',
                'alert-type' => 'error'
            ], 404);
        }

        $portfolio->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(PortfolioMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('portfolios');

        Portfolio::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function trash(PortfolioTrashRequest $request): LengthAwarePaginator
    {
        return Portfolio::select(['id', 'title', 'created_at'])
            ->filterTrash($request)
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function restore(PortfolioRestoreRequest $request): JsonResponse
    {
        Cache::forget('portfolios');
        $portfolio = Portfolio::where('id', $request->id)->withTrashed()->first();
        $portfolio->restore();
        $portfolio->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function remove(PortfolioRemoveRequest $request): JsonResponse
    {
        Cache::forget('portfolios');
        $portfolioId = $request->id;
        $data = Portfolio::where('id', $portfolioId)->withTrashed()->first();
        $data->seo()->forceDelete();
        $data->images()->detach();
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function massRemove(PortfolioMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('portfolios');
        $portfolios = Portfolio::withTrashed()->whereIn('id', $request->ids)->get();

        foreach ($portfolios as $portfolio) {
            $portfolio->seo()->forceDelete();
            $portfolio->images()->detach();
        }

        Portfolio::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
}
