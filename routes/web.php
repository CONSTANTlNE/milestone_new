<?php

use App\Http\Controllers\Frontend\HomeController;
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
});
