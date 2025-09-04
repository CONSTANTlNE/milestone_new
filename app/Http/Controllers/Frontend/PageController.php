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

    public function autoAuction(){
        $page = Page::where('template', 'frontend.pages.auto_auction')->first();
        return view('frontend.pages.auto_auction', compact('page'));
    }

    public function autoDealer(){
        $page = Page::where('template', 'frontend.pages.auto_dealer')->first();
        return view('frontend.pages.auto_dealer', compact('page'));
    }

    public function carRetailer(){
        $page = Page::where('template', 'frontend.pages.car_retailer')->first();
        return view('frontend.pages.car_retailer', compact('page'));
    }

    public function corporateGovernmentFleet(){
        $page = Page::where('template', 'frontend.pages.corporate_government_fleet')->first();
        return view('frontend.pages.corporate_government_fleet', compact('page'));
    }

    public function vehicleManufacturers(){
        $page = Page::where('template', 'frontend.pages.vehicle_manufacturers')->first();
        return view('frontend.pages.vehicle_manufacturers', compact('page'));
    }

    public function carrierDispatchers(){
        $page = Page::where('template', 'frontend.pages.carrier_dispatchers')->first();
        return view('frontend.pages.carrier_dispatchers', compact('page'));
    }

    public function b2b(){
        $page = Page::where('template', 'frontend.pages.b2b')->first();
        return view('frontend.pages.b2b', compact('page'));
    }

    public function b2bQuotation(){
        $page = Page::where('template', 'frontend.pages.b2b_quotation')->first();
        return view('frontend.pages.b2b_quotation', compact('page'));
    }

    public function b2cQuotation(){
        $page = Page::where('template', 'frontend.pages.b2c_quotation')->first();
        return view('frontend.pages.b2c_quotation', compact('page'));
    }
}
