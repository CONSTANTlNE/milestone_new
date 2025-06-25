<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Frontend\CustomerController;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/customer',
        'middleware' => ['web', 'auth:customers', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
        'as' => 'frontend.customers.'
    ], function()
{
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');
});
