<?php

namespace App\Services;

use App\Contracts\TeamInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Team\TeamCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Team\TeamUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Resources\Team\TeamResource;
use App\Models\TeamCategory;
use App\Traits\ImageUploadTrait;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Team;
use Illuminate\Support\Facades\Cache;

class TeamService implements TeamInterface
{
    use ImageUploadTrait, MultiTranslatableTrait;
    const CACHE_TTL = 86400; // 1 day

    public function getTeamPosition()
    {
        return Team::where('status', 1)->orderBy('position', 'asc')->get();
    }
    public function getSeoFirst(Team $team)
    {
        return $team->seo()->first();
    }
    public function changeStatus(ChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Team');

        $team = Team::find($data['id']);
        $team->update(['status' => $data['status']]);

        return  response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(TeamCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Team');

        $team = new Team();
        $team->setMultiTranslations($data);
        $team->status = $data['status'];
        $team->position = Team::getNextPosition();
        $team->save();
//        if(!is_null($data['teamCategory'])){
//            $team->modelCategory()->attach($data['teamCategory']);
//        }
        // Set SEO translations if available
        $team->setSeoTranslations($data);
        $this->processAndSaveImages($data, $team);
        $team->fresh();

        return response()->json([
            'team' => TeamResource::make($team),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Team $team): JsonResponse|Team
    {
        return $team;
    }

    public function edit(Team $team): Team
    {
        return $team;
    }

//    public function getTeamCategory()
//    {
//        $teamCategories = TeamCategory::where('status','1')->orderBy('position','desc')->get();
//        return $teamCategories;
//    }
//    public function getTeamCategoryIds()
//    {
//        $catIds = [];
//        $teamCategories = TeamCategory::where('status','1')->orderBy('position','desc')->get();
//        foreach($teamCategories as $category){
//            array_push($catIds,$category->id);
//        }
//        return $catIds;
//    }

    public function update(TeamUpdateRequest $request, Team $team): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Team');
        $team->setMultiTranslations($data);
        $team->status = $data['status'];
        $team->position = Team::getNextPosition();
//        if(!is_null($data['teamCategory'])){
//            $team->modelCategory()->sync($data['teamCategory']);
//        }
        $team->save();
        // Set SEO translations if available
        $team->setSeoTranslations($data);
        $this->processAndSaveImages($data, $team);
        $team->fresh();

        return response()->json([
            'team' => TeamResource::make($team),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(Team $team): JsonResponse
    {
        $team->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('Team');
        $teams = Team::whereIn('id', $request->ids);
        $teams->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    public function reorder($request)
    {
        Cache::forget('Team');
        foreach($request->order as $index => $id)
        {
            Team::find($id)->update([
                'position' => $index
            ]);
        }
        return  response()->json([
            'message' =>  __('strings.Position changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    // Archive Function Method
    public function restore($id): void
    {
        Cache::forget('Team');
        $team = Team::where('id', $id)->withTrashed()->first();
        $team->restore();
        $team->fresh();
    }

    public function remove($id): JsonResponse
    {
        Cache::forget('Team');
        Cache::forget('generalTeam'.$id);
        Cache::forget('statusImageShowTeam'.$id);
        Cache::forget('mainPdfShowTeam'.$id);
        Cache::forget('defaultImageShowTeam'.$id);
        $data = Team::where('id', $id)->withTrashed()->first();
        $data->seo()->forceDelete();
        $data->images()->detach();
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 204);
    }

    public function massRemove(MassRemoveRequest $request): JsonResponse
    {
        Cache::forget('Team');
        $teams = Team::whereIn('id', $request->ids)->get();
        foreach ($teams as $team) {
            Cache::forget('generalTeam'.$team->id);
            Cache::forget('statusImageShowTeam'.$team->id);
            Cache::forget('mainPdfShowTeam'.$team->id);
            Cache::forget('defaultImageShowTeam'.$team->id);
            $team->seo()->forceDelete();
            $team->setForceDelete(true);
            $team->images()->detach();
        }

        Team::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
