<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use App\Models\Locale;

const CACHE_TTL = 86400; // 1 day

if (! function_exists('getLangName')) {
    function getLangName($code)
    {
        if (!Cache::has('locales')){
            Cache::remember('locales', 60*60*24, function (){
                return Locale::select('id', 'title', 'native', 'code', 'status')
                    ->where('status', '1')
                    ->with('generalImage')
                    ->orderBy('position', 'asc')
                    ->get();
            });
        }
        return Cache::get('locales')->where('code', $code)->first();
    }
}

if (!function_exists('getLocaleGeneral')) {
    function getLocaleGeneral()
    {
        if (!Cache::has('locales')){
            Cache::remember('locales', 60*60*24, function (){
                return Locale::select('id', 'title', 'native', 'code', 'status')
                    ->where('status', '1')
                    ->with('generalImage')
                    ->orderBy('position', 'asc')
                    ->get();
            });
        }
        return Cache::get('locales')->where('status', 1)->first();
    }
}


if (!function_exists('getLocales')) {
    function getLocales()
    {
        if (!Cache::has('locales')){
            Cache::remember('locales', 60*60*24, function (){
                return Locale::select('id', 'title', 'native', 'code', 'status')
                    ->where('status', '1')
                    ->with('generalImage')
                    ->orderBy('position', 'asc')
                    ->get();
            });
        }
        return  Cache::get('locales')->sortByDesc('position');
    }
}

if (!function_exists('getLocalesCode')) {
    function getLocalesCode()
    {
        if (!Cache::has('getLocalesCode')){
            Cache::remember('getLocalesCode', 60*60*24, function (){
                return Locale::select('code')
                    ->where('status', '1')
                    ->groupBy('code')
                    ->pluck('code')
                    ->toArray();
            });
        }
        return  Cache::get('getLocalesCode');
    }
}

if (!function_exists('languageConfig')) {
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function languageConfig()
    {
        return app()->make(App\Services\LanguageConfigService::class);
    }
}

if (!function_exists('openJSONFile')) {
    function openJSONFile($code)
    {
        $jsonString = [];
        if(File::exists(lang_path($code.'.json'))){
            $jsonString = file_get_contents(lang_path($code.'.json'));
            $jsonString = json_decode($jsonString, true);
        }
        return $jsonString;
    }
}

if (!function_exists('saveJSONFile')) {
    function saveJSONFile($code, $data): void
    {
        ksort($data);
        $jsonData = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        file_put_contents(lang_path($code.'.json'), stripslashes($jsonData));
    }
}
