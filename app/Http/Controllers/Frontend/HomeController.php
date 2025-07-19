<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Blog;
use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $sliders = Slider::all();
        $blogs = Blog::all();

        return view('frontend.index', compact('sliders', 'blogs'));
    }

    public function under(): View
    {
        return view('frontend.under');
    }
}
