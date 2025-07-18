<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use App\Http\Responses\LoginResponse as CustomLoginResponse;
use App\Http\Responses\LogoutResponse as CustomLogoutResponse;
use Illuminate\Support\Facades\Blade;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;

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
    }
}
