<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Map\MapCategoryRepository;
use App\Interfaces\Map\MapCategoryRepositoryInterface;
use App\Http\Requests\Map\CreateMapCategory;
use App\Http\Requests\Map\UpdateMapCategory;
use App\Models\MapCategory;
use Gate;

class MapCategoryController extends Controller
{

    private $mapCategoryRepository;

    public function __construct(MapCategoryRepositoryInterface $mapCategoryRepository) 
    {
        $this->mapCategoryRepository = $mapCategoryRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.mapCategory.index');
        return $this->mapCategoryRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.mapCategory.status');
        return $this->mapCategoryRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.mapCategory.create');
        return view('backend.mapCategory.create', [
          'mapCategories' => $this->mapCategoryRepository->create()
        ]);
    }

    public function store(CreateMapCategory $request){
        Gate::authorize('backend.mapCategory.store');
        $this->mapCategoryRepository->store($request);
        return redirect()->route('backend.mapCategory.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.mapCategory.show');
        return view('backend.mapCategory.show', [
          'mapCategory' => $this->mapCategoryRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.mapCategory.edit');
        return view('backend.mapCategory.edit', [
          'mapCategory' => $this->mapCategoryRepository->edit($id),
          'allMapCategories' => $this->mapCategoryRepository->getlist()
        ]);
    }

    public function update(UpdateMapCategory $request){
        Gate::authorize('backend.mapCategory.update');
        $this->mapCategoryRepository->update($request);
        return redirect()->route('backend.mapCategory.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.mapCategory.destroy');
        $this->mapCategoryRepository->destroy($id);
        return redirect()->route('backend.mapCategory.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.mapCategory.destroy');
        return $this->mapCategoryRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->mapCategoryRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.mapCategory.trash');
        return $this->mapCategoryRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.mapCategory.restore');
        $this->mapCategoryRepository->restore($request);
        return redirect()->route('backend.mapCategory.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.mapCategory.remove');
        $this->mapCategoryRepository->remove($request);
        return redirect()->route('backend.mapCategory.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.mapCategory.remove');
        $this->mapCategoryRepository->massRemove($request);
    }
}

