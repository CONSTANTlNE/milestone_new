<?php

namespace App\Providers;

use App\Models\Availability;
use App\Models\CarBrand;
use App\Models\MenuItem;
use App\Rules\Validator\UniqueTranslationValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use App\Http\Responses\LoginResponse as CustomLoginResponse;
use App\Http\Responses\LogoutResponse as CustomLogoutResponse;
use Illuminate\Support\Facades\Blade;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Cache;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        config(['laravellocalization.supportedLocales' => json_decode(file_get_contents(lang_path('config_locales.json')), true)]);
        $this->app->singleton(LoginResponse::class, CustomLoginResponse::class);
        $this->app->singleton(LogoutResponse::class, CustomLogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('fortifyFeature', function ($feature) {
            return Features::enabled($feature);
        });
        Validator::extend('unique_translation', UniqueTranslationValidator::class.'@validate');
        // Custom blade directive for alerts
        Blade::directive('alert', function ($expression) {
            return "<?php echo view('components.backend.alert', ['type' => 'info', 'message' => $expression])->render(); ?>";
        });

        Blade::directive('alertSuccess', function ($expression) {
            return "<?php echo view('components.backend.alert', ['type' => 'success', 'message' => $expression])->render(); ?>";
        });

        Blade::directive('alertError', function ($expression) {
            return "<?php echo view('components.backend.alert', ['type' => 'error', 'message' => $expression])->render(); ?>";
        });

        Blade::directive('alertWarning', function ($expression) {
            return "<?php echo view('components.backend.alert', ['type' => 'warning', 'message' => $expression])->render(); ?>";
        });

        Blade::directive('alertInfo', function ($expression) {
            return "<?php echo view('components.backend.alert', ['type' => 'info', 'message' => $expression])->render(); ?>";
        });

//        view()->composer('frontend.layouts.mainMenu', function($view){
//            if (!Cache::has('menuItem_3')){
//                $mainMenus = Cache::remember('menuItem_3', now()->addHours(1), function () {
//                    return MenuItem::where('menu_id', 3)
//                        ->where('parent_id', 0)
//                        ->where('status', 1)
//                        ->with('children') // Ensure 'children' is cached too
//                        ->orderBy('sort', 'asc')
//                        ->get();
//                });
//            }else{
//                $mainMenus = Cache::get('menuItem_3')->where('parent_id', 0);
//            }
//            return $view->with(compact('mainMenus'));
//        });

        LogViewer::auth(function ($request) {
            return $request->user()
                && in_array($request->user()->email, [
                    'gmta.constantine@gmail.com',
                    'borisi.barabadze@gmail.com'
                ]);
        });

        view()->composer('frontend.layouts.mainMenu', function($view){
            $mainMenus = MenuItem::where('menu_id', 1)
                ->where('parent_id', 0)
                ->where('status', 1)
                ->with('children') // Ensure 'children' is cached too
                ->orderBy('sort', 'asc')
                ->get();
            return $view->with(compact('mainMenus'));
        });

        view()->composer('frontend.layouts.footer', function($view){
            $servicesMenus = MenuItem::where('menu_id', 5)
                ->where('parent_id', 0)
                ->where('status', 1)
                ->with('children') // Ensure 'children' is cached too
                ->orderBy('sort', 'asc')
                ->get();
            $linksMenus = MenuItem::where('menu_id', 6)
                ->where('parent_id', 0)
                ->where('status', 1)
                ->with('children') // Ensure 'children' is cached too
                ->orderBy('sort', 'asc')
                ->get();
            return $view->with(compact('servicesMenus', 'linksMenus'));
        });

//        view()->composer('components.frontend.index_quotation', function($view){
//            $cars = CarBrand::all();
//            $availabilities = Availability::all();
//
//            return $view->with(compact('cars', 'availabilities'));
//        });

        view()->composer(
            [
                'components.frontend.index_quotation',
                'frontend.pages.b2b_quotation',
                'frontend.pages.b2c_quotation'
            ],
            function($view) {
                $cars = CarBrand::all();
                $availabilities = Availability::all();
                $view->with(compact('cars', 'availabilities'));
            }
        );
    }
}
