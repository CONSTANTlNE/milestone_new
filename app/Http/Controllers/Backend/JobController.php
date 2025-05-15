<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Job\JobRepository;
use App\Interfaces\Job\JobRepositoryInterface;
use App\Http\Requests\Job\CreateJob;
use App\Http\Requests\Job\UpdateJob;
use App\Models\Job;
use Gate;

class JobController extends Controller
{

    private $jobRepository;

    public function __construct(JobRepositoryInterface $jobRepository) 
    {
        $this->jobRepository = $jobRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.jobs.index');
        return $this->jobRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.jobs.status');
        return $this->jobRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.jobs.create');
        return view('backend.jobs.create');
    }

    public function store(CreateJob $request){
        Gate::authorize('backend.jobs.store');
        $this->jobRepository->store($request);
        return redirect()->route('backend.jobs.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.jobs.show');
        return view('backend.jobs.show', [
          'job' => $this->jobRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.jobs.edit');
        return view('backend.jobs.edit', [
          'job' => $this->jobRepository->edit($id),
          'seo' => $this->jobRepository->getSeoFirst($id)
        ]);
    }

    public function update(UpdateJob $request){
        Gate::authorize('backend.jobs.update');
        $this->jobRepository->update($request);
        return redirect()->route('backend.jobs.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.jobs.destroy');
        $this->jobRepository->destroy($id);
        return redirect()->route('backend.jobs.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.jobs.destroy');
        return $this->jobRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->jobRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.jobs.trash');
        return $this->jobRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.jobs.restore');
        $this->jobRepository->restore($request);
        return redirect()->route('backend.jobs.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.jobs.remove');
        $this->jobRepository->remove($request);
        return redirect()->route('backend.jobs.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.jobs.remove');
        $this->jobRepository->massRemove($request);
    }
}

