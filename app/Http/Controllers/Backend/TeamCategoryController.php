<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Team\TeamCategoryRepository;
use App\Interfaces\Team\TeamCategoryRepositoryInterface;
use App\Http\Requests\Team\CreateTeamCategory;
use App\Http\Requests\Team\UpdateTeamCategory;
use App\Models\TeamCategory;
use Gate;

class TeamCategoryController extends Controller
{

    private $teamCategoryRepository;

    public function __construct(TeamCategoryRepositoryInterface $teamCategoryRepository) 
    {
        $this->teamCategoryRepository = $teamCategoryRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.teamCategory.index');
        return $this->teamCategoryRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.teamCategory.status');
        return $this->teamCategoryRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.teamCategory.create');
        return view('backend.teamCategory.create');
    }

    public function store(CreateTeamCategory $request){
        Gate::authorize('backend.teamCategory.store');
        $this->teamCategoryRepository->store($request);
        return redirect()->route('backend.teamCategory.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.teamCategory.show');
        return view('backend.teamCategory.show', [
          'teamCategory' => $this->teamCategoryRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.teamCategory.edit');
        return view('backend.teamCategory.edit', [
          'teamCategory' => $this->teamCategoryRepository->edit($id),
          'seo' => $this->teamCategoryRepository->getSeoFirst($id)
        ]);
    }

    public function update(UpdateTeamCategory $request){
        Gate::authorize('backend.teamCategory.update');
        $this->teamCategoryRepository->update($request);
        return redirect()->route('backend.teamCategory.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.teamCategory.destroy');
        $this->teamCategoryRepository->destroy($id);
        return redirect()->route('backend.teamCategory.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.teamCategory.destroy');
        return $this->teamCategoryRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->teamCategoryRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.teamCategory.trash');
        return $this->teamCategoryRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.teamCategory.restore');
        $this->teamCategoryRepository->restore($request);
        return redirect()->route('backend.teamCategory.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.teamCategory.remove');
        $this->teamCategoryRepository->remove($request);
        return redirect()->route('backend.teamCategory.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.teamCategory.remove');
        $this->teamCategoryRepository->massRemove($request);
    }
}

