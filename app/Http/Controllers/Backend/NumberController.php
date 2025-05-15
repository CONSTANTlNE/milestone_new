<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Number\NumberRepository;
use App\Interfaces\Number\NumberRepositoryInterface;
use App\Http\Requests\Number\CreateNumber;
use App\Http\Requests\Number\UpdateNumber;
use App\Models\Number;
use Gate;

class NumberController extends Controller
{

    private $numberRepository;

    public function __construct(NumberRepositoryInterface $numberRepository) 
    {
        $this->numberRepository = $numberRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.numbers.index');
        return $this->numberRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.numbers.status');
        return $this->numberRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.numbers.create');
        return view('backend.numbers.create');
    }

    public function store(CreateNumber $request){
        Gate::authorize('backend.numbers.store');
        $this->numberRepository->store($request);
        return redirect()->route('backend.numbers.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.numbers.show');
        return view('backend.numbers.show', [
          'number' => $this->numberRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.numbers.edit');
        return view('backend.numbers.edit', [
          'number' => $this->numberRepository->edit($id)
        ]);
    }

    public function update(UpdateNumber $request){
        Gate::authorize('backend.numbers.update');
        $this->numberRepository->update($request);
        return redirect()->route('backend.numbers.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.numbers.destroy');
        $this->numberRepository->destroy($id);
        return redirect()->route('backend.numbers.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.numbers.destroy');
        return $this->numberRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->numberRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.numbers.trash');
        return $this->numberRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.numbers.restore');
        $this->numberRepository->restore($request);
        return redirect()->route('backend.numbers.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.numbers.remove');
        $this->numberRepository->remove($request);
        return redirect()->route('backend.numbers.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.numbers.remove');
        $this->numberRepository->massRemove($request);
    }
}

