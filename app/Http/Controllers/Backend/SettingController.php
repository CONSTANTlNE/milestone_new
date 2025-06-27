<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    use MultiTranslatableTrait;

    public function edit($lang, $id)
    {
        return view('backend.settings.edit', [
            'setting' => Setting::first()
        ]);
    }

    public function update(Request $request, $lang, Setting $setting)
    {
        $setting->updateSettings($request->all());
        return redirect()->back();
    }

    public function clearCache(): JsonResponse
    {
        Artisan::call('cache:clear');
        return response()->json([
            'message' => __('strings.Cache facade value cleared'),
            'alert-type' => 'success'
        ]);
    }

    public function optimize(): JsonResponse
    {
        Artisan::call('optimize');
        return response()->json([
            'message' => __('strings.Re-optimized class loader'),
            'alert-type' => 'success'
        ]);
    }

    public function clearRoute(): JsonResponse
    {
        Artisan::call('route:clear');
        return response()->json([
            'message' => __('strings.Route cache cleared'),
            'alert-type' => 'success'
        ]);
    }

    public function cacheRoute(): JsonResponse
    {
        Artisan::call('route:cache');
        return response()->json([
            'message' => __('strings.Routes cached'),
            'alert-type' => 'success'
        ]);
    }

    public function clearView(): JsonResponse
    {
        Artisan::call('view:clear');
        return response()->json([
            'message' => __('strings.View cache cleared'),
            'alert-type' => 'success'
        ]);
    }

    public function cacheView(): JsonResponse
    {
        Artisan::call('view:cache');
        return response()->json([
            'message' => __('strings.Views cached'),
            'alert-type' => 'success'
        ]);
    }

    public function cacheConfig(): JsonResponse
    {
        Artisan::call('config:cache');
        return response()->json([
            'message' => __('strings.Config cached'),
            'alert-type' => 'success'
        ]);
    }

    public function clearConfig(): JsonResponse
    {
        Artisan::call('config:clear');
        return response()->json([
            'message' => __('strings.Clear Config cleared'),
            'alert-type' => 'success'
        ]);
    }

    public function storageLink()
    {
        Artisan::call('storage:link');

        return response()->json([
            'message' => __('strings.Storage link created'),
            'alert-type' => 'success'
        ]);
    }
}
