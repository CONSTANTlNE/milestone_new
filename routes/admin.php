<?php

use App\Http\Controllers\Backend\ArticleCategoryController;
use App\Http\Controllers\Backend\ArticleController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\FileManagerController;
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\SocialController;
use App\Http\Controllers\Backend\SubscriberController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Artisan;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Laravel\Fortify\RoutePath;

//admins auth routes
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['web', 'localizeValidations', 'localeSessionRedirect', 'localizationRedirect'],
    ], function()
{
    $enableViews = config('fortify.views', true);
    $limiter = config('fortify.limiters.login721');
    $twoFactorLimiter = config('fortify.limiters.two-factor');
    $verificationLimiter = config('fortify.limiters.verification', '6,1');

    // Authentication...
    if ($enableViews) {
        Route::get(RoutePath::for('login', '/login721'), [AuthenticatedSessionController::class, 'create'])
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('login');
    }

    Route::post(RoutePath::for('login', '/login721'), [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:' . config('fortify.guard'),
            $limiter ? 'throttle:' . $limiter : null,
        ]))->name('login.store');

    Route::post(RoutePath::for('logout', '/logout'), [AuthenticatedSessionController::class, 'destroy'])
        ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
        ->name('logout');

    // Password Reset...
    if (Features::enabled(Features::resetPasswords())) {
        if ($enableViews) {
            Route::get(RoutePath::for('password.request', '/forgot-password'), [PasswordResetLinkController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('password.request');

            Route::get(RoutePath::for('password.reset', '/reset-password/{token}'), [NewPasswordController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('password.reset');
        }

        Route::post(RoutePath::for('password.email', '/forgot-password'), [PasswordResetLinkController::class, 'store'])
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('password.email');

        Route::post(RoutePath::for('password.update', '/reset-password'), [NewPasswordController::class, 'store'])
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('password.update');
    }

    // Registration...
    if (Features::enabled(Features::registration())) {
        if ($enableViews) {
            Route::get(RoutePath::for('register', '/register'), [RegisteredUserController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('register');
        }

        Route::post(RoutePath::for('register', '/register'), [RegisteredUserController::class, 'store'])
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('register.store');
    }

    // Email Verification...
    if (Features::enabled(Features::emailVerification())) {
        if ($enableViews) {
            Route::get(RoutePath::for('verification.notice', '/email/verify'), [EmailVerificationPromptController::class, '__invoke'])
                ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
                ->name('verification.notice');
        }

        Route::get(RoutePath::for('verification.verify', '/email/verify/{id}/{hash}'), [VerifyEmailController::class, '__invoke'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'signed', 'throttle:' . $verificationLimiter])
            ->name('verification.verify');

        Route::post(RoutePath::for('verification.send', '/email/verification-notification'), [EmailVerificationNotificationController::class, 'store'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'throttle:' . $verificationLimiter])
            ->name('verification.send');
    }

    // Profile Information...
    if (Features::enabled(Features::updateProfileInformation())) {
        Route::put(RoutePath::for('user-profile-information.update', '/user/profile-information'), [ProfileInformationController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
            ->name('user-profile-information.update');
    }

    // Passwords...
    if (Features::enabled(Features::updatePasswords())) {
        Route::put(RoutePath::for('user-password.update', '/user/password'), [PasswordController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
            ->name('user-password.update');

        //  Password Confirmation...
        if ($enableViews) {
            Route::get(RoutePath::for('password.confirm', '/user/confirm-password'), [ConfirmablePasswordController::class, 'show'])
                ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
                ->name('password.confirm');
        }

        Route::get(RoutePath::for('password.confirmation', '/user/confirmed-password-status'), [ConfirmedPasswordStatusController::class, 'show'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
            ->name('password.confirmation');

        Route::post(RoutePath::for('password.confirm', '/user/confirm-password'), [ConfirmablePasswordController::class, 'store'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
            ->name('password.confirm.store');
    }

    // Two-Factor Authentication...
    if (Features::enabled(Features::twoFactorAuthentication())) {
        if ($enableViews) {
            Route::get(RoutePath::for('two-factor.login', '/two-factor-challenge'), [TwoFactorAuthenticatedSessionController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('two-factor.login');
        }

        Route::post(RoutePath::for('two-factor.login', '/two-factor-challenge'), [TwoFactorAuthenticatedSessionController::class, 'store'])
            ->middleware(array_filter([
                'guest:' . config('fortify.guard'),
                $twoFactorLimiter ? 'throttle:' . $twoFactorLimiter : null,
            ]))->name('two-factor.login.store');

        $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
            ? [config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'password.confirm']
            : [config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')];

        Route::post(RoutePath::for('two-factor.enable', '/user/two-factor-authentication'), [TwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.enable');

        Route::post(RoutePath::for('two-factor.confirm', '/user/confirmed-two-factor-authentication'), [ConfirmedTwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.confirm');

        Route::delete(RoutePath::for('two-factor.disable', '/user/two-factor-authentication'), [TwoFactorAuthenticationController::class, 'destroy'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.disable');

        Route::get(RoutePath::for('two-factor.qr-code', '/user/two-factor-qr-code'), [TwoFactorQrCodeController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.qr-code');

        Route::get(RoutePath::for('two-factor.secret-key', '/user/two-factor-secret-key'), [TwoFactorSecretKeyController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.secret-key');

        Route::get(RoutePath::for('two-factor.recovery-codes', '/user/two-factor-recovery-codes'), [RecoveryCodeController::class, 'index'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.recovery-codes');

        Route::post(RoutePath::for('two-factor.recovery-codes', '/user/two-factor-recovery-codes'), [RecoveryCodeController::class, 'store'])
            ->middleware($twoFactorMiddleware);
    }
});

//admins dashboard routes
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/backend',
        'middleware' => ['web', 'auth:web', 'backend', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
        'as' => 'backend.'
    ], function()
{
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('analytics', [DashboardController::class, 'analytics'])->name('dashboard.analytics');

    Route::get('clear-cache', [SettingController::class, 'clearCache'])->name('clear-cache');
    Route::get('optimize', [SettingController::class, 'optimize'])->name('optimize');

    Route::get('clear-route', [SettingController::class, 'clearRoute'])->name('clear-route');
    Route::get('cache-route', [SettingController::class, 'cacheRoute'])->name('cache-route');

    Route::get('clear-view', [SettingController::class, 'clearView'])->name('clear-view');
    Route::get('cache-view', [SettingController::class, 'cacheView'])->name('cache-view');

    Route::get('cache-config', [SettingController::class, 'cacheConfig'])->name('cache-config');
    Route::get('clear-config', [SettingController::class, 'clearConfig'])->name('clear-config');

    Route::get('storage', [SettingController::class, 'storageLink'])->name('storage.link');

    Route::get('linkstorage', function () {
        $targetFolder = base_path() . '/storage/app/public';
        $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
        symlink($targetFolder, $linkFolder);
    });

    Route::post('/files/createFolder/', [FileManagerController::class, 'createFolder'])->name('files.createFolder');
    Route::delete('/files/deleteFolder/{folder}', [FileManagerController::class, 'deleteFolder'])->name('files.deleteFolder');
    Route::post('/files/restoreFolder/{id}', [FileManagerController::class, 'restoreFolder'])->name('files.restoreFolder');
    Route::post('/files/restoreFile/{id}', [FileManagerController::class, 'restoreFile'])->name('files.restoreFile');
    Route::delete('/files/deleteFolderForever/{id}', [FileManagerController::class, 'deleteFolderForever'])->name('files.deleteFolderForever');
    Route::delete('/files/deleteFileForever/{id}', [FileManagerController::class, 'deleteFileForever'])->name('files.deleteFileForever');
    Route::get('/files/downloadOriginal/{id}', [FileManagerController::class, 'downloadOriginal'])->name('files.downloadOriginal');
    Route::post('/files/removeWatermark/{id}', [FileManagerController::class, 'removeWatermark'])->name('files.removeWatermark');


    Route::get('/files', [FileManagerController::class, 'index'])->name('files.index');
    Route::post('/files/store', [FileManagerController::class, 'store'])->name('files.store');
    Route::post('/files/update', [FileManagerController::class, 'update'])->name('files.update');
    Route::delete('/files/delete/{id}', [FileManagerController::class, 'destroy'])->name('files.destroy');

    Route::post('/files/sortImages/', [FileManagerController::class, 'nestable'])->name('files.sort');

    //languages - static
    Route::get('/locales/static', 'LanguageTranslationController@index')->name('locales.static.index');
    Route::get('/locales/staticadmin', 'LanguageTranslationController@index')->name('locales.static.staticadmin');
    Route::post('/translations/update', 'LanguageTranslationController@transUpdate')->name('translation.update.json');
    Route::post('/translations/updateKey', 'LanguageTranslationController@transUpdateKey')->name('translation.update.json.key');
    Route::post('/translations/destroy', 'LanguageTranslationController@destroy')->name('translation.destroy');
    Route::post('/translations/create', 'LanguageTranslationController@store')->name('translation.create');
    Route::post('/folders/create', 'LanguageTranslationController@folder')->name('folders.create');

    //languages additional
    Route::group(['prefix' => 'locales', 'as' => 'locales.'], function () {
        Route::get('/status/{locale}', ['uses' => 'LocaleController@status', 'as' => 'status']);
        Route::delete('/massDestroy', ['uses' => 'LocaleController@massDestroy', 'as' => 'massDestroy']);
        Route::get('/general/{locale}', ['uses' => 'LocaleController@general', 'as' => 'general']);
        Route::post('/reorder', ['uses' => 'LocaleController@reorder', 'as' => 'reorder']);
        // trash
        Route::get('/restore/{id}', ['uses' => 'LocaleController@restore', 'as' => 'restore']);
        Route::delete('/remove/{id}', ['uses' => 'LocaleController@remove', 'as' => 'remove']);
        Route::delete('/remove', ['uses' => 'LocaleController@massRemove', 'as' => 'massRemove']);
        Route::get('/trash', ['uses' => 'LocaleController@trash', 'as' => 'trash']);
    });
    Route::resource('locales', LocaleController::class);

    //users additional
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::post('/status', ['uses' => 'UserController@status', 'as' => 'status']);
        Route::delete('/massDestroy', ['uses' => 'UserController@massDestroy', 'as' => 'massDestroy']);
        // trash
        Route::get('/restore/{id}', ['uses' => 'UserController@restore', 'as' => 'restore']);
        Route::delete('/remove/{id}', ['uses' => 'UserController@remove', 'as' => 'remove']);
        Route::delete('/remove', ['uses' => 'UserController@massRemove', 'as' => 'massRemove']);
        Route::get('/trash', ['uses' => 'UserController@trash', 'as' => 'trash']);
    });
    Route::resource('users', UserController::class);

    //customers additional
    Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
        Route::post('/status', ['uses' => 'UserController@status', 'as' => 'status']);
        Route::delete('/massDestroy', ['uses' => 'UserController@massDestroy', 'as' => 'massDestroy']);
        // trash
        Route::get('/restore/{id}', ['uses' => 'UserController@restore', 'as' => 'restore']);
        Route::delete('/remove/{id}', ['uses' => 'UserController@remove', 'as' => 'remove']);
        Route::delete('/remove', ['uses' => 'UserController@massRemove', 'as' => 'massRemove']);
        Route::get('/trash', ['uses' => 'UserController@trash', 'as' => 'trash']);
    });
    Route::resource('customers', UserController::class);

    //subscribers additional
    Route::group(['prefix' => 'subscribers', 'as' => 'subscribers.'], function () {
        // trash
        Route::get('/restore/{id}', ['uses' => 'SubscriberController@restore', 'as' => 'restore']);
        Route::post('/remove/{id}', ['uses' => 'SubscriberController@remove', 'as' => 'remove']);
        Route::delete('/remove', ['uses' => 'SubscriberController@massRemove', 'as' => 'massRemove']);
        Route::get('/trash', ['uses' => 'SubscriberController@trash', 'as' => 'trash']);
    });
    Route::resource('subscribers', SubscriberController::class);

    //roles additional
    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        Route::post('/status', ['uses' => 'RoleController@status', 'as' => 'status']);
        Route::delete('/massDestroy', ['uses' => 'RoleController@massDestroy', 'as' => 'massDestroy']);
        // trash
        Route::get('/restore/{id}', ['uses' => 'RoleController@restore', 'as' => 'restore']);
        Route::delete('/remove/{id}', ['uses' => 'RoleController@remove', 'as' => 'remove']);
        Route::delete('/remove', ['uses' => 'RoleController@massRemove', 'as' => 'massRemove']);
        Route::get('/trash', ['uses' => 'RoleController@trash', 'as' => 'trash']);
    });
    Route::resource('roles', RoleController::class);

    //permissions additional
    Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function () {
        Route::post('/status', ['uses' => 'PermissionController@status', 'as' => 'status']);
        Route::delete('/massDestroy', ['uses' => 'PermissionController@massDestroy', 'as' => 'massDestroy']);
        // trash
        Route::get('/restore/{id}', ['uses' => 'PermissionController@restore', 'as' => 'restore']);
        Route::delete('/remove/{id}', ['uses' => 'PermissionController@remove', 'as' => 'remove']);
        Route::delete('/remove', ['uses' => 'PermissionController@massRemove', 'as' => 'massRemove']);
        Route::get('/trash', ['uses' => 'PermissionController@trash', 'as' => 'trash']);
    });
    Route::resource('permissions', PermissionController::class);

    //pages additional
    Route::group(['prefix' => 'pages', 'as' => 'pages.'], function () {
        Route::post('/status', ['uses' => 'PageController@status', 'as' => 'status']);
        Route::delete('/massDestroy', ['uses' => 'PageController@massDestroy', 'as' => 'massDestroy']);
        // trash
        Route::get('/restore/{id}', ['uses' => 'PageController@restore', 'as' => 'restore']);
        Route::delete('/remove/{id}', ['uses' => 'PageController@remove', 'as' => 'remove']);
        Route::delete('/remove', ['uses' => 'PageController@massRemove', 'as' => 'massRemove']);
        Route::get('/trash', ['uses' => 'PageController@trash', 'as' => 'trash']);
    });
    Route::resource('pages', PageController::class);

    //menus
    Route::group(['prefix' => 'menus', 'as' => 'menus.'], function () {
        Route::get('/', ['uses' => 'MenuController@index', 'as' => 'index']);
        Route::get('/create', ['uses' => 'MenuController@create', 'as' => 'create']);
        Route::post('/store', ['uses' => 'MenuController@store', 'as' => 'store']);
        Route::get('/show/{id}', ['uses' => 'MenuController@show', 'as' => 'show']);
        Route::get('/edit/{id}', ['uses' => 'MenuController@edit', 'as' => 'edit']);
        Route::post('/update/{id}', ['uses' => 'MenuController@update', 'as' => 'update']);
        Route::post('/delete/{id}', ['uses' => 'MenuController@destroy', 'as' => 'destroy']);
        Route::post('/status', ['uses' => 'MenuController@status', 'as' => 'status']);
        Route::post('/reorder', ['uses' => 'MenuController@reorder', 'as' => 'reorder']);
        Route::delete('/massDestroy', ['uses' => 'MenuController@massDestroy', 'as' => 'massDestroy']);
        // trash
        Route::get('/trash', ['uses' => 'MenuController@trash', 'as' => 'trash']);
        Route::get('/restore/{id}', ['uses' => 'MenuController@restore', 'as' => 'restore']);
        Route::post('/remove/{id}', ['uses' => 'MenuController@remove', 'as' => 'remove']);
        Route::delete('/remove', ['uses' => 'MenuController@massRemove', 'as' => 'massRemove']);

        // Routes for menu items
        Route::post('/updateMenu', ['uses' => 'MenuController@updateMenu', 'as' => 'updateMenu']);
        Route::post('/deleteMenu', ['uses' => 'MenuController@deleteMenu', 'as' => 'deleteMenu']);
        Route::post('/menu-items/create', ['uses' => 'MenuController@addMenuItem', 'as' => 'items.create']);
        Route::post('/menu-items/update', ['uses' => 'MenuController@updateMenuItem', 'as' => 'items.update']);
        Route::post('/menu-items/delete', ['uses' => 'MenuController@deleteMenuItem', 'as' => 'items.delete']);
    });

    //articles additional
    Route::group(['prefix' => 'articles', 'as' => 'articles.'], function () {
        Route::post('/status', ['uses' => 'ArticleController@status', 'as' => 'status']);
        Route::delete('/massDestroy', ['uses' => 'ArticleController@massDestroy', 'as' => 'massDestroy']);
        Route::post('/reorder', ['uses' => 'ArticleController@reorder', 'as' => 'reorder']);
        // trash
        Route::get('/restore/{id}', ['uses' => 'ArticleController@restore', 'as' => 'restore']);
        Route::delete('/remove/{id}', ['uses' => 'ArticleController@remove', 'as' => 'remove']);
        Route::delete('/remove', ['uses' => 'ArticleController@massRemove', 'as' => 'massRemove']);
        Route::get('/trash', ['uses' => 'ArticleController@trash', 'as' => 'trash']);
        Route::get('/up', ['uses' => 'ArticleController@up', 'as' => 'up']);
    });
    Route::resource('articles', ArticleController::class);

    //article's Categories additional
    Route::group(['prefix' => 'articleCategory', 'as' => 'articleCategory.'], function () {
        Route::post('/status', ['uses' => 'ArticleCategoryController@status', 'as' => 'status']);
        Route::delete('/massDestroy', ['uses' => 'ArticleCategoryController@massDestroy', 'as' => 'massDestroy']);
        Route::post('/reorder', ['uses' => 'ArticleCategoryController@reorder', 'as' => 'reorder']);
        // trash
        Route::get('/restore/{id}', ['uses' => 'ArticleCategoryController@restore', 'as' => 'restore']);
        Route::delete('/remove/{id}', ['uses' => 'ArticleCategoryController@remove', 'as' => 'remove']);
        Route::delete('/remove', ['uses' => 'ArticleCategoryController@massRemove', 'as' => 'massRemove']);
        Route::get('/trash', ['uses' => 'ArticleCategoryController@trash', 'as' => 'trash']);
    });
    Route::resource('articleCategory', ArticleCategoryController::class);

    //banners additional
    Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
        Route::post('/status', ['uses' => 'BannerController@status', 'as' => 'status']);
        Route::delete('/massDestroy', ['uses' => 'BannerController@massDestroy', 'as' => 'massDestroy']);
        Route::get('/position', ['uses' => 'BannerController@position', 'as' => 'position']);
        Route::post('/reorder', ['uses' => 'BannerController@reorder', 'as' => 'reorder']);
        // trash
        Route::get('/restore/{id}', ['uses' => 'BannerController@restore', 'as' => 'restore']);
        Route::delete('/remove/{id}', ['uses' => 'BannerController@remove', 'as' => 'remove']);
        Route::delete('/remove', ['uses' => 'BannerController@massRemove', 'as' => 'massRemove']);
        Route::get('/trash', ['uses' => 'BannerController@trash', 'as' => 'trash']);
    });
    Route::resource('banners', BannerController::class);

    //teams additional
    Route::group(['prefix' => 'teams', 'as' => 'teams.'], function () {
        Route::post('/status', ['uses' => 'TeamController@status', 'as' => 'status']);
        Route::delete('/massDestroy', ['uses' => 'TeamController@massDestroy', 'as' => 'massDestroy']);
        Route::get('/position', ['uses' => 'TeamController@position', 'as' => 'position']);
        Route::post('/reorder', ['uses' => 'TeamController@reorder', 'as' => 'reorder']);
        // trash
        Route::get('/restore/{id}', ['uses' => 'TeamController@restore', 'as' => 'restore']);
        Route::delete('/remove/{id}', ['uses' => 'TeamController@remove', 'as' => 'remove']);
        Route::delete('/remove', ['uses' => 'TeamController@massRemove', 'as' => 'massRemove']);
        Route::get('/trash', ['uses' => 'TeamController@trash', 'as' => 'trash']);
    });
    Route::resource('teams', TeamController::class);

    //socials additional
    Route::group(['prefix' => 'socials', 'as' => 'socials.'], function () {
        Route::post('/status', ['uses' => 'SocialController@status', 'as' => 'status']);
        Route::delete('/massDestroy', ['uses' => 'SocialController@massDestroy', 'as' => 'massDestroy']);
        Route::post('/reorder', ['uses' => 'SocialController@reorder', 'as' => 'reorder']);
        // trash
        Route::get('/restore/{id}', ['uses' => 'SocialController@restore', 'as' => 'restore']);
        Route::delete('/remove/{id}', ['uses' => 'SocialController@remove', 'as' => 'remove']);
        Route::delete('/remove', ['uses' => 'SocialController@massRemove', 'as' => 'massRemove']);
        Route::get('/trash', ['uses' => 'SocialController@trash', 'as' => 'trash']);
    });
    Route::resource('socials', SocialController::class);
//
    //contacts additional
    Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], function () {
        Route::post('/status', ['uses' => 'ContactController@status', 'as' => 'status']);
        Route::delete('/massDestroy', ['uses' => 'ContactController@massDestroy', 'as' => 'massDestroy']);
        // trash
        Route::get('/restore/{id}', ['uses' => 'ContactController@restore', 'as' => 'restore']);
        Route::delete('/remove/{id}', ['uses' => 'ContactController@remove', 'as' => 'remove']);
        Route::delete('/remove', ['uses' => 'ContactController@massRemove', 'as' => 'massRemove']);
        Route::get('/trash', ['uses' => 'ContactController@trash', 'as' => 'trash']);
    });
    Route::resource('contacts', ContactController::class);

    //settings
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('/show', ['uses' => 'SettingController@show', 'as' => 'show']);
        Route::get('/edit/{id}', ['uses' => 'SettingController@edit', 'as' => 'edit']);
        Route::post('/update/{setting}', ['uses' => 'SettingController@update', 'as' => 'update']);
    });

//        Route::group(['prefix' => 'logs', 'as' => 'logs.'], function () {
//            Route::get('/', ['uses' => 'Logs\LogsController@list', 'as' => 'list']);
//            Route::post('/view', ['uses' => 'Logs\LogsController@store', 'as' => 'store']);
//        });
//
//        // backup
//        Route::group(['prefix' => 'backups', 'as' => 'backups.'], function () {
//            Route::get('/', ['uses' => 'BackupController@backup', 'as' => 'backup']);
//            Route::post('/create', ['uses' => 'BackupController@create', 'as' => 'store']);
//            Route::get('/download/{file_name?}', ['uses' => 'BackupController@download', 'as' => 'download']);
//            Route::post('/delete/{file_name?}', ['uses' => 'BackupController@delete', 'as' => 'destroy'])->where('file_name', '(.*)');
//        });
//
//        Route::resource('image', 'ImageController');
//        Route::any('image/{id}/delete', 'ImageController@destroy');
//        Route::any('ime/{id}/{positionId}/update', 'ImageController@update');
//        Route::any('cover/{id}/{cover}/cover', 'ImageController@cover');
    Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');
});
