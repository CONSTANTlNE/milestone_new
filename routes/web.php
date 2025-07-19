<?php

use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PortfolioController;
use App\Http\Controllers\Frontend\ServiceController;
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
});
