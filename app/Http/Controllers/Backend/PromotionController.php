<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Promotion\PromotionRepository;
use App\Interfaces\Promotion\PromotionRepositoryInterface;
use App\Http\Requests\Promotion\CreatePromotion;
use App\Http\Requests\Promotion\UpdatePromotion;
use App\Models\Promotion;
use Gate;

class PromotionController extends Controller
{

    private $promotionRepository;

    public function __construct(PromotionRepositoryInterface $promotionRepository) 
    {
        $this->promotionRepository = $promotionRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.promotions.index');
        return $this->promotionRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.promotions.status');
        return $this->promotionRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.promotions.create');
        return view('backend.promotions.create');
    }

    public function store(CreatePromotion $request){
        Gate::authorize('backend.promotions.store');
        $this->promotionRepository->store($request);
        return redirect()->route('backend.promotions.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.promotions.show');
        return view('backend.promotions.show', [
          'promotion' => $this->promotionRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.promotions.edit');
        return view('backend.promotions.edit', [
          'promotion' => $this->promotionRepository->edit($id),
          'seo' => $this->promotionRepository->getSeoFirst($id),
        ]);
    }

    public function update(UpdatePromotion $request){
        Gate::authorize('backend.promotions.update');
        $this->promotionRepository->update($request);
        return redirect()->route('backend.promotions.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.promotions.destroy');
        $this->promotionRepository->destroy($id);
        return redirect()->route('backend.promotions.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.promotions.destroy');
        return $this->promotionRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->promotionRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.promotions.trash');
        return $this->promotionRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.promotions.restore');
        $this->promotionRepository->restore($request);
        return redirect()->route('backend.promotions.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.promotions.remove');
        $this->promotionRepository->remove($request);
        return redirect()->route('backend.promotions.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.promotions.remove');
        $this->promotionRepository->massRemove($request);
    }
}

