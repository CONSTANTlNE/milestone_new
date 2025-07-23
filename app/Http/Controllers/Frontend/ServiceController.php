<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceController extends Controller
{
    public function index()
    {
        $page = Page::where('template', 'frontend.services.index')->firstOrFail();
        $services = Service::whereNotNull('slug->' . app()->getLocale())
        ->where('slug->'. app()->getLocale(), "!=", '')
        ->where('status', 1)
        ->orderBy('id', 'DESC')
        ->paginate(15);
        return view('frontend.services.index', compact('services', 'page'));
    }

    public function category($id)
    {
        $category = ServiceCategory::find($id);
        $services = $category->services()
                ->whereNotNull('slug->' . app()->getLocale())
                ->where('slug->'.app()->getLocale(), "!=", '')
                ->where('status', 1)
                ->orderBy('id', 'DESC')
                ->paginate(15);

        return view('frontend.serviceCategories.show', compact('category', 'services'));
    }

    public function show($id)
    {
        $service = Service::whereNotNull('slug->'.app()->getLocale())
            ->where('slug->'.app()->getLocale(), "!=", '')
            ->where('id', $id)
            ->first();
        $services = Service::whereNotNull('slug->' . app()->getLocale())
            ->where('slug->'. app()->getLocale(), "!=", '')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->get();
        return view('frontend.services.show', compact('service', 'services'));
    }
}
