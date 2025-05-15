<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Blog\BlogRepository;
use App\Interfaces\Blog\BlogRepositoryInterface;
use App\Http\Requests\Blog\CreateBlog;
use App\Http\Requests\Blog\UpdateBlog;
use App\Models\Blog;
use Gate;

class BlogController extends Controller
{
    private $blogRepository;

    public function __construct(BlogRepositoryInterface $blogRepository) 
    {
        $this->blogRepository = $blogRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.blogs.index');
        return $this->blogRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.blogs.status');
        return $this->blogRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.blogs.create');
        return view('backend.blogs.create', [
          'blogCategories' => $this->blogRepository->create()
        ]);
    }

    public function store(CreateBlog $request){
        Gate::authorize('backend.blogs.store');
        $this->blogRepository->store($request);
        return redirect()->route('backend.blogs.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.blogs.show');
        return view('backend.blogs.show', [
          'blog' => $this->blogRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.blogs.edit');
        return view('backend.blogs.edit', [
          'blog' => $this->blogRepository->edit($id),
          'seo' => $this->blogRepository->getSeoFirst($id),
          'blogCategories' => $this->blogRepository->getBlogCategory(),
          'catIds' => $this->blogRepository->getBlogCategoryIds()
        ]);
    }

    public function update(UpdateBlog $request){
        Gate::authorize('backend.blogs.update');
        $this->blogRepository->update($request);
        return redirect()->route('backend.blogs.index', app()->getLocale())
                      ->with('success','წარმატებით განახლდა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.blogs.destroy');
        $this->blogRepository->destroy($id);
        return redirect()->route('backend.blogs.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.blogs.destroy');
        return $this->blogRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->blogRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.blogs.trash');
        return $this->blogRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.blogs.restore');
        $this->blogRepository->restore($request);
        return redirect()->route('backend.blogs.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.blogs.remove');
        $this->blogRepository->remove($request);
        return redirect()->route('backend.blogs.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.blogs.remove');
        $this->blogRepository->massRemove($request);
    }
}

