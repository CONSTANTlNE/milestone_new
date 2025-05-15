<?php

namespace App\Http\Controllers\Backend;

use App\Contracts\TeamInterface;
use App\DataTables\TeamsDataTable;
use App\DataTables\TeamsDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\Team\TeamCreateRequest;
use App\Http\Requests\Team\TeamUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Services\TeamService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Team;
use Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class TeamController extends Controller
{
    private TeamService $teamService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
        $this->authorizeResource(Team::class, 'team');
    }
    /**
     * View all teams.
     *
     * @param TeamsDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(TeamsDataTable $dataTable)
    {
        $this->authorize('viewAny', Team::class);
        return $dataTable->render('backend.teams.index');
    }

    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',Team::class);
        try {
            return $this->teamService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status team: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create view the specified resource.
     *
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create', Team::class);
        return view('backend.teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeamCreateRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(TeamCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Team::class);
        try {
            $this->teamService->store($request);
            return redirect()->route('backend.teams.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating team: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param Team $team
     * @return JsonResponse|View
     */
    public function show($lang, Team $team): JsonResponse|View
    {
        $this->authorize('view', $team);
        try {
            return view('backend.teams.show', [
                'team' => $this->teamService->show($team)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the team: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param Team $team
     * @return JsonResponse|View
     */
    public function edit($lang, Team $team): JsonResponse|View
    {
        $this->authorize('update', $team);
        try {
            return view('backend.teams.edit', [
                'team' => $this->teamService->edit($team),
                'seo' => $this->teamService->getSeoFirst($team)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the team: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param Team $team
     * @return JsonResponse|View
     */
    public function update($lang, TeamUpdateRequest $request, Team $team): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $team);
        try {
            $this->teamService->update($request, $team);
            return redirect()->route('backend.teams.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating user: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Team.
     * @param $lang
     * @param Team $team
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, Team $team): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $team);
        try {
            $this->teamService->destroy($team);
            return redirect()->route('backend.teams.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting team: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Team.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', Team::class);
        try {
            $this->teamService->massDestroy($request);
            return redirect()->route('backend.teams.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting team: ' . $e->getMessage()
            ], 500);
        }
    }

    public function position()
    {
        $this->authorize('position', Team::class);
        return view('backend.teams.position', [
            'teams' => $this->teamService->getTeamPosition()
        ]);
    }

    public function reorder(Request $request)
    {
        return $this->teamService->reorder($request);
    }
    // Archive
    /**
     * View all Teams in Trash.
     *
     * @param TeamsDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(TeamsDataTableTrash $dataTable)
    {
        $this->authorize('trash', Team::class);
        return $dataTable->render('backend.teams.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Team::class);
        try {
            $this->teamService->restore($id);
            return redirect()->route('backend.teams.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring team: ' . $e->getMessage()
            ], 500);
        }
    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Team::class);
        try {
            $this->teamService->remove($id);
            return redirect()->route('backend.teams.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing team: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Team::class);
        try {
            $this->teamService->massRemove($request);
            return redirect()->route('backend.teams.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing team: ' . $e->getMessage()
            ], 500);
        }
    }
}
