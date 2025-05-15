<?php

use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Backend\ArticleCategoryController;
use App\Http\Controllers\Backend\ArticleController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\DataController;
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\Backend\MediaController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\PartnerController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\PersonController;
use App\Http\Controllers\Backend\RegionController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SocialController;
use App\Http\Controllers\Backend\SubscriberController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\VerdictController;
use App\Http\Controllers\Backend\VersusController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/backend',
        'middleware' => ['web', 'auth', 'backend', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
        'as' => 'backend.'
    ], function()
{
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::get('clear-cache', function () {
        Artisan::call('cache:clear');
        return response()->json([
            'message' => __('strings.Cache facade value cleared'),
            'alert-type' => 'success'
        ]);
    })->name('clear-cache');

    Route::get('clear-route', function () {
        Artisan::call('route:clear');
        return response()->json([
            'message' => __('strings.Route cache cleared'),
            'alert-type' => 'success'
        ]);
    })->name('clear-route');

    Route::get('clear-view', function () {
        Artisan::call('view:clear');
        return response()->json([
            'message' => __('strings.View cache cleared'),
            'alert-type' => 'success'
        ]);
    })->name('clear-view');

    Route::get('cache-route', function () {
        Artisan::call('route:cache');
        return response()->json([
            'message' => __('strings.Routes cached'),
            'alert-type' => 'success'
        ]);
    })->name('cache-route');

    Route::get('cache-config', function () {
        Artisan::call('config:cache');
        return response()->json([
            'message' => __('strings.Clear Config cleared'),
            'alert-type' => 'success'
        ]);
    })->name('cache-config');


    Route::get('optimize', function () {
        Artisan::call('optimize');
        return response()->json([
            'message' => __('strings.Re-optimized class loader'),
            'alert-type' => 'success'
        ]);
    })->name('optimize');

    Route::get('storage', function () {
        Artisan::call('storage:link');
        return response()->json([
            'message' => __('strings.Clear Config cleared'),
            'alert-type' => 'success'
        ]);
    });

    Route::get('linkstorage', function () {
        $targetFolder = base_path() . '/storage/app/public';
        $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
        symlink($targetFolder, $linkFolder);
    });

//    Route::post('/files/createFolder/', 'FileManagerController@createFolder')->name('files.createFolder');
//    Route::delete('/files/deleteFolder/{folder}', 'FileManagerController@deleteFolder')->name('files.deleteFolder');
//    Route::post('/files/restoreFolder/{id}', 'FileManagerController@restoreFolder')->name('files.restoreFolder');
//    Route::post('/files/restoreFile/{id}', 'FileManagerController@restoreFile')->name('files.restoreFile');
//    Route::delete('/files/deleteFolderForever/{id}', 'FileManagerController@deleteFolderForever')->name('files.deleteFolderForever');
//    Route::delete('/files/deleteFileForever/{id}', 'FileManagerController@deleteFileForever')->name('files.deleteFileForever');
//    Route::get('/files/downloadOriginal/{id}', 'FileManagerController@downloadOriginal')->name('files.downloadOriginal');
//    Route::post('/files/removeWatermark/{id}', 'FileManagerController@removeWatermark')->name('files.removeWatermark');
//
//
//    Route::get('/files', 'FileManagerController@index')->name('files.index');
//    Route::post('/files/store', 'FileManagerController@store')->name('files.store');
//    Route::post('/files/update', 'FileManagerController@update')->name('files.update');
//    Route::delete('/files/delete/{id}', 'FileManagerController@destroy')->name('files.destroy');
//
//    Route::post('/files/sortImages/', 'FileManagerController@nestable')->name('files.sort');
//
//    //languages - static
//    Route::get('/locales/static', 'LanguageTranslationController@index')->name('locales.static.index');
//    Route::get('/locales/staticadmin', 'LanguageTranslationController@index')->name('locales.static.staticadmin');
//    Route::post('/translations/update', 'LanguageTranslationController@transUpdate')->name('translation.update.json');
//    Route::post('/translations/updateKey', 'LanguageTranslationController@transUpdateKey')->name('translation.update.json.key');
//    Route::post('/translations/destroy', 'LanguageTranslationController@destroy')->name('translation.destroy');
//    Route::post('/translations/create', 'LanguageTranslationController@store')->name('translation.create');
//    Route::post('/folders/create', 'LanguageTranslationController@folder')->name('folders.create');
//
//    //languages additional
//    Route::group(['prefix' => 'locales', 'as' => 'locales.'], function () {
//        Route::get('/status/{locale}', ['uses' => 'LocaleController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'LocaleController@massDestroy', 'as' => 'massDestroy']);
//        Route::get('/general/{locale}', ['uses' => 'LocaleController@general', 'as' => 'general']);
//        Route::post('/reorder', ['uses' => 'LocaleController@reorder', 'as' => 'reorder']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'LocaleController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'LocaleController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'LocaleController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'LocaleController@trash', 'as' => 'trash']);
//    });
//    Route::resource('locales', LocaleController::class);
//
//    //users additional
//    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
//        Route::post('/status', ['uses' => 'UserController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'UserController@massDestroy', 'as' => 'massDestroy']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'UserController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'UserController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'UserController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'UserController@trash', 'as' => 'trash']);
//    });
//    Route::resource('users', UserController::class);
//
//    //subscribers additional
//    Route::group(['prefix' => 'subscribers', 'as' => 'subscribers.'], function () {
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'SubscriberController@restore', 'as' => 'restore']);
//        Route::post('/remove/{id}', ['uses' => 'SubscriberController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'SubscriberController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'SubscriberController@trash', 'as' => 'trash']);
//    });
//    Route::resource('subscribers', SubscriberController::class);
//
//    //roles additional
//    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
//        Route::post('/status', ['uses' => 'RoleController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'RoleController@massDestroy', 'as' => 'massDestroy']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'RoleController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'RoleController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'RoleController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'RoleController@trash', 'as' => 'trash']);
//    });
//    Route::resource('roles', RoleController::class);
//
//    //permissions additional
//    Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function () {
//        Route::post('/status', ['uses' => 'PermissionController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'PermissionController@massDestroy', 'as' => 'massDestroy']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'PermissionController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'PermissionController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'PermissionController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'PermissionController@trash', 'as' => 'trash']);
//    });
//    Route::resource('permissions', PermissionController::class);
//
//    //pages additional
//    Route::group(['prefix' => 'pages', 'as' => 'pages.'], function () {
//        Route::post('/status', ['uses' => 'PageController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'PageController@massDestroy', 'as' => 'massDestroy']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'PageController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'PageController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'PageController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'PageController@trash', 'as' => 'trash']);
//    });
//    Route::resource('pages', PageController::class);
//
//    //menus
//    Route::group(['prefix' => 'menus', 'as' => 'menus.'], function () {
//        Route::get('/', ['uses' => 'MenuController@index', 'as' => 'index']);
//        Route::get('/create', ['uses' => 'MenuController@create', 'as' => 'create']);
//        Route::post('/store', ['uses' => 'MenuController@store', 'as' => 'store']);
//        Route::get('/show/{id}', ['uses' => 'MenuController@show', 'as' => 'show']);
//        Route::get('/edit/{id}', ['uses' => 'MenuController@edit', 'as' => 'edit']);
//        Route::post('/update/{id}', ['uses' => 'MenuController@update', 'as' => 'update']);
//        Route::post('/delete/{id}', ['uses' => 'MenuController@destroy', 'as' => 'destroy']);
//        Route::post('/status', ['uses' => 'MenuController@status', 'as' => 'status']);
//        Route::post('/reorder', ['uses' => 'MenuController@reorder', 'as' => 'reorder']);
//        Route::delete('/massDestroy', ['uses' => 'MenuController@massDestroy', 'as' => 'massDestroy']);
//        // trash
//        Route::get('/trash', ['uses' => 'MenuController@trash', 'as' => 'trash']);
//        Route::get('/restore/{id}', ['uses' => 'MenuController@restore', 'as' => 'restore']);
//        Route::post('/remove/{id}', ['uses' => 'MenuController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'MenuController@massRemove', 'as' => 'massRemove']);
//
//        // Routes for menu items
//        Route::post('/updateMenu', ['uses' => 'MenuController@updateMenu', 'as' => 'updateMenu']);
//        Route::post('/deleteMenu', ['uses' => 'MenuController@deleteMenu', 'as' => 'deleteMenu']);
//        Route::post('/menu-items/create', ['uses' => 'MenuController@addMenuItem', 'as' => 'items.create']);
//        Route::post('/menu-items/update', ['uses' => 'MenuController@updateMenuItem', 'as' => 'items.update']);
//        Route::post('/menu-items/delete', ['uses' => 'MenuController@deleteMenuItem', 'as' => 'items.delete']);
//    });
//
//    //articles additional
//    Route::group(['prefix' => 'articles', 'as' => 'articles.'], function () {
//        Route::post('/status', ['uses' => 'ArticleController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'ArticleController@massDestroy', 'as' => 'massDestroy']);
//        Route::post('/reorder', ['uses' => 'ArticleController@reorder', 'as' => 'reorder']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'ArticleController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'ArticleController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'ArticleController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'ArticleController@trash', 'as' => 'trash']);
//        Route::get('/up', ['uses' => 'ArticleController@up', 'as' => 'up']);
//    });
//    Route::resource('articles', ArticleController::class);
//
//    //versus additional
//    Route::group(['prefix' => 'versus', 'as' => 'versus.'], function () {
//        Route::post('/status', ['uses' => 'VersusController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'VersusController@massDestroy', 'as' => 'massDestroy']);
//        Route::post('/reorder', ['uses' => 'VersusController@reorder', 'as' => 'reorder']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'VersusController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'VersusController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'VersusController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'VersusController@trash', 'as' => 'trash']);
//    });
//    Route::resource('versus', VersusController::class);
//
//    //article's Categories additional
//    Route::group(['prefix' => 'articleCategory', 'as' => 'articleCategory.'], function () {
//        Route::post('/status', ['uses' => 'ArticleCategoryController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'ArticleCategoryController@massDestroy', 'as' => 'massDestroy']);
//        Route::post('/reorder', ['uses' => 'ArticleCategoryController@reorder', 'as' => 'reorder']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'ArticleCategoryController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'ArticleCategoryController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'ArticleCategoryController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'ArticleCategoryController@trash', 'as' => 'trash']);
//    });
//    Route::resource('articleCategory', ArticleCategoryController::class);
//
//    //medias additional
//    Route::group(['prefix' => 'medias', 'as' => 'medias.'], function () {
//        Route::post('/status', ['uses' => 'MediaController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'MediaController@massDestroy', 'as' => 'massDestroy']);
//        Route::post('/reorder', ['uses' => 'MediaController@reorder', 'as' => 'reorder']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'MediaController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'MediaController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'MediaController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'MediaController@trash', 'as' => 'trash']);
//    });
//    Route::resource('medias', MediaController::class);
//
//    //regions additional
//    Route::group(['prefix' => 'regions', 'as' => 'regions.'], function () {
//        Route::post('/status', ['uses' => 'RegionController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'RegionController@massDestroy', 'as' => 'massDestroy']);
//        Route::post('/reorder', ['uses' => 'RegionController@reorder', 'as' => 'reorder']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'RegionController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'RegionController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'RegionController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'RegionController@trash', 'as' => 'trash']);
//        Route::get('/rewrite', ['uses' => 'RegionController@rewrite', 'as' => 'rewrite']);
//        Route::post('/rewriteRegion', ['uses' => 'RegionController@rewriteRegion', 'as' => 'rewriteRegion']);
//    });
//    Route::resource('regions', RegionController::class);
//
//    //partners additional
//    Route::group(['prefix' => 'partners', 'as' => 'partners.'], function () {
//        Route::post('/status', ['uses' => 'PartnerController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'PartnerController@massDestroy', 'as' => 'massDestroy']);
//        Route::get('/position', ['uses' => 'PartnerController@position', 'as' => 'position']);
//        Route::post('/reorder', ['uses' => 'PartnerController@reorder', 'as' => 'reorder']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'PartnerController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'PartnerController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'PartnerController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'PartnerController@trash', 'as' => 'trash']);
//    });
//    Route::resource('partners', PartnerController::class);
//
//    //banners additional
//    Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
//        Route::post('/status', ['uses' => 'BannerController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'BannerController@massDestroy', 'as' => 'massDestroy']);
//        Route::get('/position', ['uses' => 'BannerController@position', 'as' => 'position']);
//        Route::post('/reorder', ['uses' => 'BannerController@reorder', 'as' => 'reorder']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'BannerController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'BannerController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'BannerController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'BannerController@trash', 'as' => 'trash']);
//    });
//    Route::resource('banners', BannerController::class);
//
//    //teams additional
//    Route::group(['prefix' => 'teams', 'as' => 'teams.'], function () {
//        Route::post('/status', ['uses' => 'TeamController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'TeamController@massDestroy', 'as' => 'massDestroy']);
//        Route::get('/position', ['uses' => 'TeamController@position', 'as' => 'position']);
//        Route::post('/reorder', ['uses' => 'TeamController@reorder', 'as' => 'reorder']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'TeamController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'TeamController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'TeamController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'TeamController@trash', 'as' => 'trash']);
//    });
//    Route::resource('teams', TeamController::class);
//
//    //persons additional
//    Route::group(['prefix' => 'persons', 'as' => 'persons.'], function () {
//        Route::post('/status', ['uses' => 'PersonController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'PersonController@massDestroy', 'as' => 'massDestroy']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'PersonController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'PersonController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'PersonController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'PersonController@trash', 'as' => 'trash']);
//    });
//    Route::resource('persons', PersonController::class);
//
//    //verdicts additional
//    Route::group(['prefix' => 'verdicts', 'as' => 'verdicts.'], function () {
//        Route::post('/status', ['uses' => 'VerdictController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'VerdictController@massDestroy', 'as' => 'massDestroy']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'VerdictController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'VerdictController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'VerdictController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'VerdictController@trash', 'as' => 'trash']);
//        Route::get('/rewrite', ['uses' => 'VerdictController@rewrite', 'as' => 'rewrite']);
//        Route::post('/rewriteVerdict', ['uses' => 'VerdictController@rewriteVerdict', 'as' => 'rewriteVerdict']);
//    });
//    Route::resource('verdicts', VerdictController::class);
//
//    //datas additional
//    Route::group(['prefix' => 'data', 'as' => 'data.'], function () {
//        Route::post('/status', ['uses' => 'DataController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'DataController@massDestroy', 'as' => 'massDestroy']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'DataController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'DataController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'DataController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'DataController@trash', 'as' => 'trash']);
//    });
//    Route::resource('data', DataController::class);
//
//    //socials additional
//    Route::group(['prefix' => 'socials', 'as' => 'socials.'], function () {
//        Route::post('/status', ['uses' => 'SocialController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'SocialController@massDestroy', 'as' => 'massDestroy']);
//        Route::post('/reorder', ['uses' => 'SocialController@reorder', 'as' => 'reorder']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'SocialController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'SocialController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'SocialController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'SocialController@trash', 'as' => 'trash']);
//    });
//    Route::resource('socials', SocialController::class);
////
//    //contacts additional
//    Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], function () {
//        Route::post('/status', ['uses' => 'ContactController@status', 'as' => 'status']);
//        Route::delete('/massDestroy', ['uses' => 'ContactController@massDestroy', 'as' => 'massDestroy']);
//        // trash
//        Route::get('/restore/{id}', ['uses' => 'ContactController@restore', 'as' => 'restore']);
//        Route::delete('/remove/{id}', ['uses' => 'ContactController@remove', 'as' => 'remove']);
//        Route::delete('/remove', ['uses' => 'ContactController@massRemove', 'as' => 'massRemove']);
//        Route::get('/trash', ['uses' => 'ContactController@trash', 'as' => 'trash']);
//    });
//    Route::resource('contacts', ContactController::class);
//
//    //settings
//    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
//        Route::get('/edit/{id}', ['uses' => 'SettingController@edit', 'as' => 'edit']);
//        Route::post('/update/{setting}', ['uses' => 'SettingController@update', 'as' => 'update']);
//    });

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
