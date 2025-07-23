<?php

use App\Http\Controllers\Backend\Projects\FaqController;
use App\Http\Controllers\Backend\Projects\ServiceCategoryController;
use App\Http\Controllers\Backend\Projects\ServiceController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\FileManagerController;
use App\Http\Controllers\Backend\LanguageTranslationController;
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\Projects\BlogCategoryController;
use App\Http\Controllers\Backend\Projects\BlogController;
use App\Http\Controllers\Backend\Projects\PortfolioController;
use App\Http\Controllers\Backend\Projects\SliderController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\SocialController;
use App\Http\Controllers\Backend\SubscriberController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
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
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Laravel\Fortify\RoutePath;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Frontend\QuotationController;


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
    Route::get('/locales/static', [LanguageTranslationController::class, 'index'])->name('localeStatics.index');
    Route::get('/locales/staticadmin', [LanguageTranslationController::class, 'index'])->name('localeStatics.staticadmin');

    Route::post('/translations/update', [LanguageTranslationController::class, 'transUpdate'])->name('translation.update.json');
    Route::post('/translations/updateKey', [LanguageTranslationController::class, 'transUpdateKey'])->name('translation.update.json.key');
    Route::post('/translations/destroy', [LanguageTranslationController::class, 'destroy'])->name('translation.destroy');
    Route::post('/translations/create', [LanguageTranslationController::class, 'store'])->name('translation.create');

    Route::post('/folders/create', [LanguageTranslationController::class, 'folder'])->name('folders.create');

// locales
    Route::prefix('locales')->as('locales.')->group(function () {
        // Additional routes
        Route::post('status', [LocaleController::class, 'status'])->name('status');
        Route::post('delete/{id}', [LocaleController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [LocaleController::class, 'massDestroy'])->name('massDestroy');
        Route::post('reorder', [LocaleController::class, 'reorder'])->name('reorder');

        // Trash-related
        Route::post('/restore/{id}', [LocaleController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [LocaleController::class, 'remove'])->name('remove');
        Route::post('/remove', [LocaleController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [LocaleController::class, 'trash'])->name('trash');
    });
    Route::resource('locales', LocaleController::class);
// users
    Route::prefix('users')->name('users.')->group(function () {
        // Additional routes
        Route::post('status', [UserController::class, 'status'])->name('status');
        Route::post('delete/{id}', [UserController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [UserController::class, 'massDestroy'])->name('massDestroy');

        // Trash-related
        Route::post('/restore/{id}', [UserController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [UserController::class, 'remove'])->name('remove');
        Route::post('/remove', [UserController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [UserController::class, 'trash'])->name('trash');
    });
    Route::resource('users', UserController::class);
// customers
    Route::prefix('customers')->name('customers.')->group(function () {
        // Additional routes
        Route::post('status', [UserController::class, 'status'])->name('status');
        Route::post('delete/{id}', [UserController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [UserController::class, 'massDestroy'])->name('massDestroy');

        // Trash-related
        Route::post('/restore/{id}', [UserController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [UserController::class, 'remove'])->name('remove');
        Route::post('/remove', [UserController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [UserController::class, 'trash'])->name('trash');
    });
    Route::resource('customers', UserController::class);
// subscribers
    Route::prefix('subscribers')->name('subscribers.')->group(function () {
        // Additional routes
        Route::post('status', [SubscriberController::class, 'status'])->name('status');
        Route::post('delete/{id}', [SubscriberController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [SubscriberController::class, 'massDestroy'])->name('massDestroy');

        // Trash-related
        Route::post('/restore/{id}', [SubscriberController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [SubscriberController::class, 'remove'])->name('remove');
        Route::post('/remove', [SubscriberController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [SubscriberController::class, 'trash'])->name('trash');
    });
    Route::resource('subscribers', SubscriberController::class);
// roles
    Route::prefix('roles')->name('roles.')->group(function () {
        // Additional routes
        Route::post('status', [RoleController::class, 'status'])->name('status');
        Route::post('delete/{id}', [RoleController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [RoleController::class, 'massDestroy'])->name('massDestroy');

        // Trash-related
        Route::post('/restore/{id}', [RoleController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [RoleController::class, 'remove'])->name('remove');
        Route::post('/remove', [RoleController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [RoleController::class, 'trash'])->name('trash');
    });
    Route::resource('roles', RoleController::class);
// permissions
    Route::prefix('permissions')->name('permissions.')->group(function () {
        // Additional routes
        Route::post('status', [PermissionController::class, 'status'])->name('status');
        Route::post('delete/{id}', [PermissionController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [PermissionController::class, 'massDestroy'])->name('massDestroy');

        // Trash-related
        Route::post('/restore/{id}', [PermissionController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [PermissionController::class, 'remove'])->name('remove');
        Route::post('/remove', [PermissionController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [PermissionController::class, 'trash'])->name('trash');
    });
    Route::resource('permissions', PermissionController::class);
//pages
    Route::prefix('pages')->as('pages.')->group(function () {
        // Additional routes
        Route::post('status', [PageController::class, 'status'])->name('status');
        Route::post('delete/{id}', [PageController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [PageController::class, 'massDestroy'])->name('massDestroy');

        // Trash-related
        Route::post('/restore/{id}', [PageController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [PageController::class, 'remove'])->name('remove');
        Route::post('/remove', [PageController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [PageController::class, 'trash'])->name('trash');
    });
    Route::resource('pages', PageController::class);
//sliders
    Route::prefix('sliders')->name('sliders.')->group(function () {
        // Additional routes
        Route::post('status', [SliderController::class, 'status'])->name('status');
        Route::post('delete/{id}', [SliderController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [SliderController::class, 'massDestroy'])->name('massDestroy');
        Route::post('reorder', [SliderController::class, 'reorder'])->name('reorder');

        // Trash-related
        Route::post('/restore/{id}', [SliderController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [SliderController::class, 'remove'])->name('remove');
        Route::post('/remove', [SliderController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [SliderController::class, 'trash'])->name('trash');
    });
    Route::resource('sliders', SliderController::class);
//portfolios
    Route::prefix('portfolios')->name('portfolios.')->group(function () {
        // Additional routes
        Route::post('status', [PortfolioController::class, 'status'])->name('status');
        Route::post('delete/{id}', [PortfolioController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [PortfolioController::class, 'massDestroy'])->name('massDestroy');

        // Trash-related
        Route::post('/restore/{id}', [PortfolioController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [PortfolioController::class, 'remove'])->name('remove');
        Route::post('/remove', [PortfolioController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [PortfolioController::class, 'trash'])->name('trash');
    });
    Route::resource('portfolios', PortfolioController::class);

    Route::prefix('menus')->name('menus.')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::post('/store', [MenuController::class, 'store'])->name('store');
        Route::get('/show/{id}', [MenuController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [MenuController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [MenuController::class, 'destroy'])->name('destroy');
        Route::post('/status', [MenuController::class, 'status'])->name('status');
        Route::post('/reorder', [MenuController::class, 'reorder'])->name('reorder');
        Route::delete('/massDestroy', [MenuController::class, 'massDestroy'])->name('massDestroy');
        Route::get('/trash', [MenuController::class, 'trash'])->name('trash');
        Route::get('/restore/{id}', [MenuController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [MenuController::class, 'remove'])->name('remove');
        Route::delete('/remove', [MenuController::class, 'massRemove'])->name('massRemove');

        Route::post('/updateMenu', [MenuController::class, 'updateMenu'])->name('updateMenu');
        Route::post('/deleteMenu', [MenuController::class, 'deleteMenu'])->name('deleteMenu');
        Route::post('/menu-items/create', [MenuController::class, 'addMenuItem'])->name('items.create');
        Route::post('/menu-items/update', [MenuController::class, 'updateMenuItem'])->name('items.update');
        Route::post('/menu-items/delete', [MenuController::class, 'deleteMenuItem'])->name('items.delete');
        Route::post('/menu-items/delete-all', [MenuController::class, 'deleteAllMenuItems'])->name('items.deleteAll');
    });
//blogs
    Route::prefix('blogs')->name('blogs.')->group(function () {
        // Additional routes
        Route::post('status', [BlogController::class, 'status'])->name('status');
        Route::post('delete/{id}', [BlogController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [BlogController::class, 'massDestroy'])->name('massDestroy');

        // Trash-related
        Route::post('/restore/{id}', [BlogController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [BlogController::class, 'remove'])->name('remove');
        Route::post('/remove', [BlogController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [BlogController::class, 'trash'])->name('trash');
    });
    Route::resource('blogs', BlogController::class);
//blogCategory
    Route::prefix('blogCategories')->name('blogCategories.')->group(function () {
        // Additional routes
        Route::post('status', [BlogCategoryController::class, 'status'])->name('status');
        Route::post('delete/{id}', [BlogCategoryController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [BlogCategoryController::class, 'massDestroy'])->name('massDestroy');

        // Trash-related
        Route::post('/restore/{id}', [BlogCategoryController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [BlogCategoryController::class, 'remove'])->name('remove');
        Route::post('/remove', [BlogCategoryController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [BlogCategoryController::class, 'trash'])->name('trash');
    });
    Route::resource('blogCategories', BlogCategoryController::class);
//tags
    Route::prefix('tags')->name('tags.')->group(function () {
        // Additional routes
        Route::post('status', [BlogCategoryController::class, 'status'])->name('status');
        Route::post('delete/{id}', [BlogCategoryController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [BlogCategoryController::class, 'massDestroy'])->name('massDestroy');
        Route::post('reorder', [BlogCategoryController::class, 'reorder'])->name('reorder');

        // Trash-related
        Route::post('/restore/{id}', [BlogCategoryController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [BlogCategoryController::class, 'remove'])->name('remove');
        Route::post('/remove', [BlogCategoryController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [BlogCategoryController::class, 'trash'])->name('trash');
    });
    Route::resource('tags', BlogCategoryController::class);
//socials
    Route::prefix('socials')->as('socials.')->group(function () {
        // Additional routes
        Route::post('status', [SocialController::class, 'status'])->name('status');
        Route::post('delete/{id}', [SocialController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [SocialController::class, 'massDestroy'])->name('massDestroy');
        Route::post('reorder', [SocialController::class, 'reorder'])->name('reorder');

        // Trash-related
        Route::post('/restore/{id}', [SocialController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [SocialController::class, 'remove'])->name('remove');
        Route::post('/remove', [SocialController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [SocialController::class, 'trash'])->name('trash');
    });
    Route::resource('socials', SocialController::class);

//faqs
    Route::prefix('faqs')->as('faqs.')->group(function () {
        // Additional routes
        Route::post('status', [FaqController::class, 'status'])->name('status');
        Route::post('delete/{id}', [FaqController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [FaqController::class, 'massDestroy'])->name('massDestroy');
        Route::post('reorder', [FaqController::class, 'reorder'])->name('reorder');

        // Trash-related
        Route::post('/restore/{id}', [FaqController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [FaqController::class, 'remove'])->name('remove');
        Route::post('/remove', [FaqController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [FaqController::class, 'trash'])->name('trash');
    });
    Route::resource('faqs', FaqController::class);
//services
    Route::prefix('services')->as('services.')->group(function () {
        // Additional routes
        Route::post('status', [ServiceController::class, 'status'])->name('status');
        Route::post('delete/{id}', [ServiceController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [ServiceController::class, 'massDestroy'])->name('massDestroy');

        // Trash-related
        Route::post('/restore/{id}', [ServiceController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [ServiceController::class, 'remove'])->name('remove');
        Route::post('/remove', [ServiceController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [ServiceController::class, 'trash'])->name('trash');
    });
    Route::resource('services', ServiceController::class);
//serviceCategory
    Route::prefix('serviceCategories')->name('serviceCategories.')->group(function () {
        // Additional routes
        Route::post('status', [ServiceCategoryController::class, 'status'])->name('status');
        Route::post('delete/{id}', [ServiceCategoryController::class, 'destroy'])->name('delete');
        Route::post('massDestroy', [ServiceCategoryController::class, 'massDestroy'])->name('massDestroy');

        // Trash-related
        Route::post('/restore/{id}', [ServiceCategoryController::class, 'restore'])->name('restore');
        Route::post('/remove/{id}', [ServiceCategoryController::class, 'remove'])->name('remove');
        Route::post('/remove', [ServiceCategoryController::class, 'massRemove'])->name('massRemove');
        Route::get('/trash', [ServiceCategoryController::class, 'trash'])->name('trash');
    });
    Route::resource('serviceCategories', ServiceCategoryController::class);
//services
//    Route::prefix('services')->as('services.')->group(function () {
//        // Additional routes
//        Route::post('status', [SocialController::class, 'status'])->name('status');
//        Route::post('delete/{id}', [SocialController::class, 'destroy'])->name('delete');
//        Route::post('massDestroy', [SocialController::class, 'massDestroy'])->name('massDestroy');
//        Route::post('reorder', [SocialController::class, 'reorder'])->name('reorder');
//// htmx
//        route::get('/service/get/htmx', 'getServiceHtmx')->name('service.get.htmx');
//        route::post('/service/upload/image/htmx', 'uploadImageHtmx')->name('service.upload.image.htmx');
//
//        // Trash-related
//        Route::post('/restore/{id}', [SocialController::class, 'restore'])->name('restore');
//        Route::post('/remove/{id}', [SocialController::class, 'remove'])->name('remove');
//        Route::post('/remove', [SocialController::class, 'massRemove'])->name('massRemove');
//        Route::get('/trash', [SocialController::class, 'trash'])->name('trash');
//    });
//    Route::resource('services', SocialController::class);

//quotations
//    Route::prefix('quotations')->as('quotations.')->group(function () {
//        // Additional routes
//        Route::post('delete/{id}', [SocialController::class, 'destroy'])->name('delete');
//        Route::post('massDestroy', [SocialController::class, 'massDestroy'])->name('massDestroy');
//
//        Route::get('/quotations', 'getQuotation')->name('quotations.get');
//        Route::post('/quotation/delete', 'delete')->name('quotation.delete');
//        Route::post('/calculate/distance', 'calculateDistance')->name('distance.calculate');
//
//        // Trash-related
//        Route::post('/restore/{id}', [SocialController::class, 'restore'])->name('restore');
//        Route::post('/remove/{id}', [SocialController::class, 'remove'])->name('remove');
//        Route::post('/remove', [SocialController::class, 'massRemove'])->name('massRemove');
//        Route::get('/trash', [SocialController::class, 'trash'])->name('trash');
//    });
//    Route::resource('quotations', SocialController::class);
//
//    Route::prefix('contacts')->name('contacts.')->group(function () {
//        Route::post('/status', [ContactController::class, 'status'])->name('status');
//        Route::delete('/massDestroy', [ContactController::class, 'massDestroy'])->name('massDestroy');
//        Route::get('/restore/{id}', [ContactController::class, 'restore'])->name('restore');
//        Route::delete('/remove/{id}', [ContactController::class, 'remove'])->name('remove');
//        Route::delete('/remove', [ContactController::class, 'massRemove'])->name('massRemove');
//        Route::get('/trash', [ContactController::class, 'trash'])->name('trash');
//    });
//    Route::resource('contacts', ContactController::class);
//settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/edit', [SettingController::class, 'edit'])->name('edit');
        Route::post('/update/{setting}', [SettingController::class, 'update'])->name('update');
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

    Route::controller(QuotationController::class)->group(function () {
        Route::get('quotations','index')->name('quotations.index');
        Route::post('/quotation/delete', 'delete')->name('quotations.delete');
        Route::post('/calculate/distance', 'calculateDistance')->name('quotations.calculatedistance');
        route::post('/quotation/request/ai/data', 'requestAiData')->name('quotations.airequest');
    });
//    Route::controller(ServiceController::class)->group(function () {
//        route::get('/service/create', 'createService')->name('service.create');
//        route::post('/service/store', 'storeService')->name('service.store');
//        route::get('/service/all', 'adminAllService')->name('service.all');
//        route::get('/service/edit/{service}', 'editService')->name('service.edit');
//        route::post('/service/update', 'updateService')->name('service.update');
//        route::post('/service/delete', 'deleteService')->name('service.delete');
//        route::get('/service/get/htmx', 'getServiceHtmx')->name('service.get.htmx');
//        route::post('/service/upload/image/htmx', 'uploadImageHtmx')->name('service.upload.image.htmx');
//    });

    Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');
});
