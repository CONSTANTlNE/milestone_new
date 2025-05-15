<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Faq\FaqRepository;
use App\Interfaces\Faq\FaqRepositoryInterface;
use App\Http\Requests\Faq\CreateFaq;
use App\Http\Requests\Faq\UpdateFaq;
use App\Models\Faq;
use Gate;

class FaqController extends Controller
{
    private $faqRepository;

    public function __construct(FaqRepositoryInterface $faqRepository) 
    {
        $this->faqRepository = $faqRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.faqs.index');
        return $this->faqRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.faqs.status');
        return $this->faqRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.faqs.create');
        return view('backend.faqs.create', [
          'faqCategories' => $this->faqRepository->create()
        ]);
    }

    public function store(CreateFaq $request){
        Gate::authorize('backend.faqs.store');
        $this->faqRepository->store($request);
        return redirect()->route('backend.faqs.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.faqs.show');
        return view('backend.faqs.show', [
          'faq' => $this->faqRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.faqs.edit');
        return view('backend.faqs.edit', [
          'faq' => $this->faqRepository->edit($id),
          'faqCategories' => $this->faqRepository->getFaqCategory(),
          'catIds' => $this->faqRepository->getFaqCategoryIds()
        ]);
    }

    public function update(UpdateFaq $request){
        Gate::authorize('backend.faqs.update');
        $this->faqRepository->update($request);
        return redirect()->route('backend.faqs.index', app()->getLocale())
                      ->with('success','წარმატებით განახლდა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.faqs.destroy');
        $this->faqRepository->destroy($id);
        return redirect()->route('backend.faqs.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.faqs.destroy');
        return $this->faqRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->faqRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.faqs.trash');
        return $this->faqRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.faqs.restore');
        $this->faqRepository->restore($request);
        return redirect()->route('backend.faqs.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.faqs.remove');
        $this->faqRepository->remove($request);
        return redirect()->route('backend.faqs.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.faqs.remove');
        $this->faqRepository->massRemove($request);
    }
}

