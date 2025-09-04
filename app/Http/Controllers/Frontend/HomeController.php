<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Availability;
use App\Models\Blog;
use App\Models\CarBrand;
use App\Models\Page;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $sliders = Slider::select(['id', 'title', 'src', 'slogan', 'url', 'content', 'status'])
            ->where('status', true)
            ->orderby('position', 'asc')
            ->limit(3)
            ->get();

        $serviceCategories = ServiceCategory::all();
        $formPages = Page::where('parent_id', 12)
            ->where('status', true)
            ->orderby('id', 'asc')
            ->get();

        $blogs = Blog::select(['id', 'title', 'slug', 'src', 'status', 'created_at'])
            ->where('status', true)
            ->orderby('id', 'desc')
            ->limit(6)
            ->get();

        $page = Page::where('template', 'frontend.index')->first();


        return view('frontend.index', compact('sliders', 'blogs', 'page', 'formPages', 'serviceCategories'));
    }

    public function under(): View
    {
        return view('frontend.under');
    }
}
