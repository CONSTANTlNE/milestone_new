<?php

use App\Http\Controllers\Frontend\AutoAuctionController;
use App\Http\Controllers\Frontend\AutoDealerController;
use App\Http\Controllers\Frontend\CarRetailerController;
use App\Http\Controllers\Frontend\CarrierDispatcherController;
use App\Http\Controllers\Frontend\VehicleManufacturerController;
use App\Http\Controllers\Frontend\CorporateGovernmentFleetController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PortfolioController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Mail\NewQuotationEmail;
use App\Models\Quotation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Laravel\Fortify\Fortify;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localizeValidations', 'localize', 'localeSessionRedirect', 'localizationRedirect'],
        'as' => 'frontend.'
    ], function()
{
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/{id}-{slug}', [BlogController::class, 'show'])->name('blogs.show');
    Route::get('/blogCategories/{id}-{slug}', [BlogController::class, 'category'])->name('blogCategories.show');
    Route::get('/portfolios', [PortfolioController::class, 'index'])->name('portfolios.index');
    Route::get('/portfolios/{id}-{slug}', [PortfolioController::class, 'show'])->name('portfolios.show');
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{id}-{slug}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/serviceCategories/{id}-{slug}', [ServiceController::class, 'category'])->name('serviceCategories.show');
    Route::get('/about-us', [PageController::class, 'about'])->name('pages.about');
    Route::get('/contact-us', [PageController::class, 'contact'])->name('pages.contact');
    Route::get('/faq', [PageController::class, 'faq'])->name('pages.faq');
    Route::get('/page/{id}-{slug}', [PageController::class, 'show'])->name('pages.show');
    Route::get('/email', function(){
        return view('email.quotation_offer_templ');
    }) ->name('pages.show');

    // Auto-related pages
    Route::get('/auto-auction', [PageController::class, 'autoAuction'])->name('pages.auto_auction');
    Route::post('/auto-auction', [AutoAuctionController::class, 'store'])->name('auto_auction.store');
    Route::get('/auto-dealer', [PageController::class, 'autoDealer'])->name('pages.auto_dealer');
    Route::post('/auto-dealer', [AutoDealerController::class, 'store'])->name('auto_dealer.store');
    Route::get('/car-retailer', [PageController::class, 'carRetailer'])->name('pages.car_retailer');
    Route::post('/car-retailer', [CarRetailerController::class, 'store'])->name('car_retailer.store');
    Route::get('/corporate-government-fleet', [PageController::class, 'corporateGovernmentFleet'])->name('pages.corporate_government_fleet');
    Route::post('/corporate-government-fleet', [CorporateGovernmentFleetController::class, 'store'])->name('corporate_government_fleet.store');
    Route::get('/vehicle-manufacturers', [PageController::class, 'vehicleManufacturers'])->name('pages.vehicle_manufacturers');
    Route::post('/vehicle-manufacturers', [VehicleManufacturerController::class, 'store'])->name('vehicle_manufacturer.store');
    Route::get('/carrier-dispatchers', [PageController::class, 'carrierDispatchers'])->name('pages.carrier_dispatchers');
    Route::post('/carrier-dispatchers', [CarrierDispatcherController::class, 'store'])->name('carrier_dispatcher.store');
    Route::get('/b2b', [PageController::class, 'b2b'])->name('pages.b2b');
    Route::get('/b2b-quotation', [PageController::class, 'b2bQuotation'])->name('pages.b2b_quotation');
    Route::get('/b2c-quotation', [PageController::class, 'b2cQuotation'])->name('pages.b2c_quotation');
});

route::get('testmail', function(){
    $user=\App\Models\User::where('email','gmta.constantine@gmail.com')->first();
    $quotations=\App\Models\Quotationb2b::where('quotation_identifier','B2B-20250815154819-8183')->get();
    Mail::to($user->email)
        ->cc('michael@milestonebrokers.us')
        ->send(new \App\Mail\NewB2bQuotationEmail($quotations->first()->email,$quotations));
    return 'email sent';
});

route::get('testmail2', function(){
    $user=\App\Models\User::where('email','gmta.constantine@gmail.com')->first();
    $quotations=Quotation::first();
    Mail::to($user->email)
        ->cc('michael@milestonebrokers.us')
        ->send(new \App\Mail\NewQuotationEmail($quotations->email,$quotations));
    return 'email sent';
});





