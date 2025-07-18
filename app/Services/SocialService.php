<?php

namespace App\Services;

use App\Contracts\SocialInterface;
use App\Http\Requests\Social\SocialChangeStatusRequest;
use App\Http\Requests\Social\SocialCreateRequest;
use App\Http\Requests\Social\SocialDestroyRequest;
use App\Http\Requests\Social\SocialMassDestroyRequest;
use App\Http\Requests\Social\SocialMassRemoveRequest;
use App\Http\Requests\Social\SocialRemoveRequest;
use App\Http\Requests\Social\SocialRestoreRequest;
use App\Http\Requests\Social\SocialTrashRequest;
use App\Http\Requests\Social\SocialUpdateRequest;
use App\Http\Resources\Social\SocialResource;
use Illuminate\Http\JsonResponse;
use App\Models\Social;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Social\SocialIndexRequest;

class SocialService implements SocialInterface
{
    public function index(SocialIndexRequest $request): LengthAwarePaginator
    {
        return Social::query()
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

    public function changeStatus(SocialChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('socials');

        $social = Social::find($data['id']);

        if (!$social) {
            return response()->json([
                'message' => 'Social not found',
                'alert-type' => 'error'
            ], 404);
        }

        $social->update(['status' => $data['status']]);
        $social->save();

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(SocialCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('socials');

        $social = new Social();
        $social->title = $data['title'];
        $social->icon = $data['icon'];
        $social->url = $data['url'];
        $social->status = $data['status'];
        $social->position = Social::getNextPosition();
        $social->created_at = $data['published_at'] ?? now();
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
        Cache::forget('socials');
        $social->title = $data['title'];
        $social->icon = $data['icon'];
        $social->url = $data['url'];
        $social->status = $data['status'];
        $social->created_at = $data['published_at'] ?? now();
        $social->save();
        $social->fresh();

        return response()->json([
            'social' => SocialResource::make($social),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(SocialDestroyRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('socials');
        $social = Social::find($data['id']);
        if (!$social) {
            return response()->json([
                'message' => 'Social not found',
                'alert-type' => 'error'
            ], 404);
        }
        $social->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(SocialMassDestroyRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('socials');
        Social::whereIn('id', $data['ids'])->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    public function reorder($request): JsonResponse
    {
        Cache::forget('socials');
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
    public function trash(SocialTrashRequest $request): LengthAwarePaginator
    {
        return Social::onlyTrashed()
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

    public function restore(SocialRestoreRequest $request): JsonResponse
    {
        Cache::forget('socials');
        $social = Social::where('id', $request->id)->withTrashed()->first();
        $social->restore();
        $social->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function remove(SocialRemoveRequest $request): JsonResponse
    {
        Cache::forget('socials');
        $socialId = $request->id;
        $data = Social::where('id', $socialId)->withTrashed()->first();
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function massRemove(SocialMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('socials');
        Social::whereIn('id', $request->ids)->withTrashed()->forceDelete();
        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
}
