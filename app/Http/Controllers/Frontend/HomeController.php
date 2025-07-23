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
        $sliders = Slider::all();
        $serviceCategories = ServiceCategory::all();
        $services = Service::all();
        $blogs = Blog::all();
        $page = Page::where('template', 'frontend.index')->first();

        return view('frontend.index', compact('sliders', 'blogs', 'page', 'services', 'serviceCategories'));
    }

    public function under(): View
    {
        return view('frontend.under');
    }
}
