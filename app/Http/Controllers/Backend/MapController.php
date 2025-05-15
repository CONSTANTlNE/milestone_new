<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Map\MapRepository;
use App\Interfaces\Map\MapRepositoryInterface;
use App\Http\Requests\Map\CreateMap;
use App\Http\Requests\Map\UpdateMap;
use App\Models\Map;
use Gate;

class MapController extends Controller
{
    private $mapRepository;

    public function __construct(MapRepositoryInterface $mapRepository) 
    {
        $this->mapRepository = $mapRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.maps.index');
        return $this->mapRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.maps.status');
        return $this->mapRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.maps.create');
        return view('backend.maps.create', [
          'mapCategories' => $this->mapRepository->create()
        ]);
    }

    public function store(CreateMap $request){
        Gate::authorize('backend.maps.store');
        $this->mapRepository->store($request);
        return redirect()->route('backend.maps.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.maps.show');
        return view('backend.maps.show', [
          'map' => $this->mapRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.maps.edit');
        return view('backend.maps.edit', [
          'map' => $this->mapRepository->edit($id),
          'mapCategories' => $this->mapRepository->getMapCategory(),
          'catIds' => $this->mapRepository->getMapCategoryIds()
        ]);
    }

    public function update(UpdateMap $request){
        Gate::authorize('backend.maps.update');
        $this->mapRepository->update($request);
        return redirect()->route('backend.maps.index', app()->getLocale())
                      ->with('success','წარმატებით განახლდა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.maps.destroy');
        $this->mapRepository->destroy($id);
        return redirect()->route('backend.maps.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.maps.destroy');
        return $this->mapRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->mapRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.maps.trash');
        return $this->mapRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.maps.restore');
        $this->mapRepository->restore($request);
        return redirect()->route('backend.maps.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.maps.remove');
        $this->mapRepository->remove($request);
        return redirect()->route('backend.maps.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.maps.remove');
        $this->mapRepository->massRemove($request);
    }
}

