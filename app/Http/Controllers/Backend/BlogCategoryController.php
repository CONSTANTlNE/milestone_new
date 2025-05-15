<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Blog\BlogCategoryRepository;
use App\Interfaces\Blog\BlogCategoryRepositoryInterface;
use App\Http\Requests\Blog\CreateBlogCategory;
use App\Http\Requests\Blog\UpdateBlogCategory;
use App\Models\BlogCategory;
use Gate;

class BlogCategoryController extends Controller
{

    private $blogCategoryRepository;

    public function __construct(BlogCategoryRepositoryInterface $blogCategoryRepository) 
    {
        $this->blogCategoryRepository = $blogCategoryRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.blogCategory.index');
        return $this->blogCategoryRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.blogCategory.status');
        return $this->blogCategoryRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.blogCategory.create');
        return view('backend.blogCategory.create', [
          'blogCategories' => $this->blogCategoryRepository->create()
        ]);
    }

    public function store(CreateBlogCategory $request){
        Gate::authorize('backend.blogCategory.store');
        $this->blogCategoryRepository->store($request);
        return redirect()->route('backend.blogCategory.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.blogCategory.show');
        return view('backend.blogCategory.show', [
          'blogCategory' => $this->blogCategoryRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.blogCategory.edit');
        return view('backend.blogCategory.edit', [
          'blogCategory' => $this->blogCategoryRepository->edit($id),
          'seo' => $this->blogCategoryRepository->getSeoFirst($id),
          'allBlogCategories' => $this->blogCategoryRepository->getlist()
        ]);
    }

    public function update(UpdateBlogCategory $request){
        Gate::authorize('backend.blogCategory.update');
        $this->blogCategoryRepository->update($request);
        return redirect()->route('backend.blogCategory.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.blogCategory.destroy');
        $this->blogCategoryRepository->destroy($id);
        return redirect()->route('backend.blogCategory.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.blogCategory.destroy');
        return $this->blogCategoryRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->blogCategoryRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.blogCategory.trash');
        return $this->blogCategoryRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.blogCategory.restore');
        $this->blogCategoryRepository->restore($request);
        return redirect()->route('backend.blogCategory.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.blogCategory.remove');
        $this->blogCategoryRepository->remove($request);
        return redirect()->route('backend.blogCategory.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.blogCategory.remove');
        $this->blogCategoryRepository->massRemove($request);
    }
}

