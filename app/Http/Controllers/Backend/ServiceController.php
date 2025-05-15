<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Service\ServiceRepository;
use App\Interfaces\Service\ServiceRepositoryInterface;
use App\Http\Requests\Service\CreateService;
use App\Http\Requests\Service\UpdateService;
use App\Models\Service;
use Gate;

class ServiceController extends Controller
{

    private $serviceRepository;

    public function __construct(ServiceRepositoryInterface $serviceRepository) 
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.services.index');
        return $this->serviceRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.services.status');
        return $this->serviceRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.services.create');
        return view('backend.services.create');
    }

    public function store(CreateService $request){
        Gate::authorize('backend.services.store');
        $this->serviceRepository->store($request);
        return redirect()->route('backend.services.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.services.show');
        return view('backend.services.show', [
          'service' => $this->serviceRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.services.edit');
        return view('backend.services.edit', [
          'service' => $this->serviceRepository->edit($id),
          'seo' => $this->serviceRepository->getSeoFirst($id)
        ]);
    }

    public function update(UpdateService $request){
        Gate::authorize('backend.services.update');
        $this->serviceRepository->update($request);
        return redirect()->route('backend.services.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.services.destroy');
        $this->serviceRepository->destroy($id);
        return redirect()->route('backend.services.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.services.destroy');
        return $this->serviceRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->serviceRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.services.trash');
        return $this->serviceRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.services.restore');
        $this->serviceRepository->restore($request);
        return redirect()->route('backend.services.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.services.remove');
        $this->serviceRepository->remove($request);
        return redirect()->route('backend.services.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.services.remove');
        $this->serviceRepository->massRemove($request);
    }
}

