<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Faq\FaqCategoryRepository;
use App\Interfaces\Faq\FaqCategoryRepositoryInterface;
use App\Http\Requests\Faq\CreateFaqCategory;
use App\Http\Requests\Faq\UpdateFaqCategory;
use App\Models\FaqCategory;
use Gate;

class FaqCategoryController extends Controller
{

    private $faqCategoryRepository;

    public function __construct(FaqCategoryRepositoryInterface $faqCategoryRepository) 
    {
        $this->faqCategoryRepository = $faqCategoryRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.faqCategory.index');
        return $this->faqCategoryRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.faqCategory.status');
        return $this->faqCategoryRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.faqCategory.create');
        return view('backend.faqCategory.create', [
          'faqCategories' => $this->faqCategoryRepository->create()
        ]);
    }

    public function store(CreateFaqCategory $request){
        Gate::authorize('backend.faqCategory.store');
        $this->faqCategoryRepository->store($request);
        return redirect()->route('backend.faqCategory.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.faqCategory.show');
        return view('backend.faqCategory.show', [
          'faqCategory' => $this->faqCategoryRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.faqCategory.edit');
        return view('backend.faqCategory.edit', [
          'faqCategory' => $this->faqCategoryRepository->edit($id),
          'allFaqCategories' => $this->faqCategoryRepository->getlist()
        ]);
    }

    public function update(UpdateFaqCategory $request){
        Gate::authorize('backend.faqCategory.update');
        $this->faqCategoryRepository->update($request);
        return redirect()->route('backend.faqCategory.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.faqCategory.destroy');
        $this->faqCategoryRepository->destroy($id);
        return redirect()->route('backend.faqCategory.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.faqCategory.destroy');
        return $this->faqCategoryRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->faqCategoryRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.faqCategory.trash');
        return $this->faqCategoryRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.faqCategory.restore');
        $this->faqCategoryRepository->restore($request);
        return redirect()->route('backend.faqCategory.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.faqCategory.remove');
        $this->faqCategoryRepository->remove($request);
        return redirect()->route('backend.faqCategory.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.faqCategory.remove');
        $this->faqCategoryRepository->massRemove($request);
    }
}

