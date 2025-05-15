<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Project\ProjectRepository;
use App\Interfaces\Project\ProjectRepositoryInterface;
use App\Http\Requests\Project\CreateProject;
use App\Http\Requests\Project\UpdateProject;
use App\Models\Project;
use Gate;

class ProjectController extends Controller
{

    private $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository) 
    {
        $this->projectRepository = $projectRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.projects.index');
        return $this->projectRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.projects.status');
        return $this->projectRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.projects.create');
        return view('backend.projects.create');
    }

    public function store(CreateProject $request){
        Gate::authorize('backend.projects.store');
        $this->projectRepository->store($request);
        return redirect()->route('backend.projects.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.projects.show');
        return view('backend.projects.show', [
          'project' => $this->projectRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.projects.edit');
        return view('backend.projects.edit', [
          'project' => $this->projectRepository->edit($id),
          'seo' => $this->projectRepository->getSeoFirst($id),
        ]);
    }

    public function update(UpdateProject $request){
        Gate::authorize('backend.projects.update');
        $this->projectRepository->update($request);
        return redirect()->route('backend.projects.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.projects.destroy');
        $this->projectRepository->destroy($id);
        return redirect()->route('backend.projects.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.projects.destroy');
        return $this->projectRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->projectRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.projects.trash');
        return $this->projectRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.projects.restore');
        $this->projectRepository->restore($request);
        return redirect()->route('backend.projects.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.projects.remove');
        $this->projectRepository->remove($request);
        return redirect()->route('backend.projects.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.projects.remove');
        $this->projectRepository->massRemove($request);
    }
}

