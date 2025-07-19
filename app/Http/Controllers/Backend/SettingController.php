<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Traits\MultiTranslatableTrait;
use App\Http\Requests\Setting\SettingUpdateRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    use MultiTranslatableTrait;

    public function edit()
    {
        return view('backend.settings.edit', [
            'setting' => Setting::first()
        ]);
    }

    public function update(SettingUpdateRequest $request, Setting $setting): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();
        Cache::forget('settings');
        $setting->updateSettings($data);
        return redirect()->back()->with('success', __('strings.Updated Successfully'));
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
