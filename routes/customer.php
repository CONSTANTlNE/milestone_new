<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Frontend\CustomerController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Laravel\Fortify\RoutePath;

// customers auth routes
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/customer',
        'middleware' => ['web', 'localizeValidations', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
        'as' => 'frontend.auth.'
    ], function()
{
    $enableViews = config('fortify.views_customers', true);

    // Authentication...
    if ($enableViews) {
        Route::get(RoutePath::for('login', '/login'), [AuthenticatedSessionController::class, 'create'])
            ->middleware(['guest:customers'])
            ->name('login');
    }

    $limiter = config('fortify.limiters.login');
    $verificationLimiter = config('fortify.limiters.verification', '6,1');

    Route::post(RoutePath::for('login', '/login'), [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:customers',
            $limiter ? 'throttle:' . $limiter : null,
        ]))->name('login.store');

    Route::post(RoutePath::for('logout', '/logout'), [AuthenticatedSessionController::class, 'destroy'])
        ->middleware([config('fortify.auth_middleware', 'auth') . ':customers'])
        ->name('logout');

    // Password Reset...
    if (feature_enabled_for_customer(Features::resetPasswords())) {
        Route::get(RoutePath::for('password.request', '/forgot-password'), [PasswordResetLinkController::class, 'create'])
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('password.request');

        Route::get(RoutePath::for('password.reset', '/reset-password/{token}'), [NewPasswordController::class, 'create'])
            ->middleware(['guest:customers'])
            ->name('password.reset');

        Route::post(RoutePath::for('password.email', '/forgot-password'), [PasswordResetLinkController::class, 'store'])
            ->middleware(['guest:customers'])
            ->name('password.email');

        Route::post(RoutePath::for('password.update', '/reset-password'), [NewPasswordController::class, 'store'])
            ->middleware(['guest:customers'])
            ->name('password.update');
    }

    // Registration...
    if (feature_enabled_for_customer(Features::registration())) {
        Route::get(RoutePath::for('register', '/register'), [RegisteredUserController::class, 'create'])
            ->middleware(['guest:customers'])
            ->name('register');

        Route::post(RoutePath::for('register', '/register'), [RegisteredUserController::class, 'store'])
            ->middleware(['guest:customers'])
            ->name('register.store');
    }

    // Email Verification...
    if (feature_enabled_for_customer(Features::emailVerification())) {
        Route::get(RoutePath::for('verification.notice', '/email/verify'), [EmailVerificationPromptController::class, '__invoke'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':customers'])
            ->name('verification.notice');

        Route::get(RoutePath::for('verification.verify', '/email/verify/{id}/{hash}'), [VerifyEmailController::class, '__invoke'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':customers', 'signed', 'throttle:' . $verificationLimiter])
            ->name('verification.verify');

        Route::post(RoutePath::for('verification.send', '/email/verification-notification'), [EmailVerificationNotificationController::class, 'store'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':customers', 'throttle:' . $verificationLimiter])
            ->name('verification.send');
    }
});

// customers dashboard routes
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
