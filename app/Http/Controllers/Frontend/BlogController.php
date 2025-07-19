<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Page;

class BlogController extends Controller
{
    public function index()
    {
        $page = Page::where('template', 'frontend.blogs.index')->first();
        $blogs = Blog::whereNotNull('slug->' . app()->getLocale())
        ->where('slug->'. app()->getLocale(), "!=", '')
        ->where('status', 1)
        ->orderBy('id', 'DESC')
        ->paginate(15);

        $blogCategories = BlogCategory::where('status', 1)->orderBy('id', 'DESC')->get();

        return view('frontend.blogs.index', compact('blogs', 'page', 'blogCategories'));
    }

    public function category($id)
    {
        $page = BlogCategory::find($id);

        $blogCategories = BlogCategory::where('status', 1)->orderBy('id', 'DESC')->get();

         $categoryBlogs = $page->blogs()
            ->whereNotNull('slug->' . app()->getLocale())
            ->where('slug->'. app()->getLocale(), "!=", '')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->paginate(15);

        return view('frontend.blogCategories.show', compact('page', 'categoryBlogs', 'blogCategories'));
    }

    public function show($id)
    {
        $blogCategories = BlogCategory::where('status', 1)->orderBy('id', 'DESC')->get();

        $blog = Blog::whereNotNull('slug->'.app()->getLocale())
            ->where('slug->'.app()->getLocale(), "!=", '')
            ->where('id', $id)
            ->first();
        return view('frontend.blogs.show', compact('blog', 'blogCategories'));
    }
}
