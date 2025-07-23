<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Page;
use App\Models\ServiceCategory;
use App\Models\Setting;

class PageController extends Controller
{
    public function show($id)
    {
        $page = Page::findOrFail($id);

        if (is_null($page)) {
            abort(404);
        }

        if (is_null($page->title)) {
            abort(404);
        }

        return view('frontend.pages.show', compact('page'));
    }

    public function about(){
        $page = Page::where('template', 'frontend.pages.about')->first();
        $serviceCategories = ServiceCategory::where('status', true)->get();
        return view('frontend.pages.about', compact('page', 'serviceCategories'));
    }

    public function faq(){
        $page = Page::where('template', 'frontend.pages.faq')->first();
        $faqs = Faq::where('service_id', null)->where('status', true)->get();
        return view('frontend.pages.faq', compact('page', 'faqs'));
    }

    public function contact(){
        $page = Page::where('template', 'frontend.pages.contact')->first();
        $setting = Setting::first();
        return view('frontend.pages.contact', compact('page', 'setting'));
    }
}
