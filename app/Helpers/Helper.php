<?php


use App\Models\Locale;
use App\Models\Setting;
use App\Models\Partner;
use App\Models\Social;
use App\Models\Page;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\Features;

if (! function_exists('feature_enabled_for_customer')) {
    function feature_enabled_for_customer($feature): bool
    {
        return in_array($feature, config('fortify.feature_customers', []));
    }
}

if (!function_exists('image_file_path')) {
    /**
     * Replace part of the file path and check if the file exists.
     *
     * @param string $path
     * @param string $size
     * @return string
     */
    function image_file_path(string $path, string $size): string
    {
        // Decode the JSON path
        $x = json_decode($path);

        // Check if $x is an array and contains at least one element
        if (is_array($x) && isset($x[0])) {
            $path = $x[0]->src;
            $newPath = str_replace('files', "files/$size", $path);
            $relativePath = str_replace('storage/files/', '', $newPath);

            // Check if the file exists in the storage disk
            return Storage::disk('files')->exists($relativePath) ? $newPath : config('filemanager.default_seo_image');
        }

        // If $x is not an array or doesn't contain the first element, return the default image
        return config('filemanager.default_seo_image');
    }
}

if (! function_exists('isNotEmptyContent')) {
    function isNotEmptyContent($column, $locale): string
    {
        return "JSON_UNQUOTE(JSON_EXTRACT($column, '$.$locale')) IS NOT NULL AND
                JSON_UNQUOTE(JSON_EXTRACT($column, '$.$locale')) != '' AND
                TRIM(JSON_UNQUOTE(JSON_EXTRACT($column, '$.$locale')) != ''";
    }
}

if (! function_exists('getPartners')) {
    function getPartners()
    {
        if (Cache::has('partners')){
            $partners = Cache::get('partners');
        } else {
            $partners = Cache::remember('partners', 60*60*24, function (){
                return Partner::all();
            });
        }
        return  Partner::where('status', 1)->orderby('position', 'asc')->get();
    }
}


if (! function_exists('is_not_null')) {
    function is_not_null($value): array
    {
        return array_filter($value, fn($value) => !is_null($value));
    }
}

if (! function_exists('checkHasTitleTrans')) {
    function checkHasTitleTrans($all): int
    {
        $titles = array_filter($all->all(), function ($value, $key) {
            return strpos($key, 'title_') === 0 && $value !== null;
        }, ARRAY_FILTER_USE_BOTH);

        return count($titles);
    }
}

if (! function_exists('checkHasAboutTrans')) {
    function checkHasAboutTrans($all): int
    {
        $abouts = array_filter($all->all(), function ($value, $key) {
            return strpos($key, 'about_') === 0 && $value !== null;
        }, ARRAY_FILTER_USE_BOTH);

        return count($abouts);
    }
}

if (! function_exists('checkHasWorkTrans')) {
    function checkHasWorkTrans($all): int
    {
        $abouts = array_filter($all->all(), function ($value, $key) {
            return strpos($key, 'work_') === 0 && $value !== null;
        }, ARRAY_FILTER_USE_BOTH);

        return count($abouts);
    }
}

if (!function_exists('youtubeLink')) {
    function youtubeLink($link)
    {
        $youtubeLink=explode("=", $link);
        return  $youtubeLink[1];
    }

}

if (!function_exists('getSocials')) {
    function getSocials()
    {
        if (Cache::has('Social')){
            $socials = Cache::get('Social');
        } else {
            $socials = Cache::remember('Social', 60*60*24, function (){
                return Social::orderBy('position', 'asc')->get();
            });
        }
        return  $socials;
    }
}

if (!function_exists('getContact')) {
    function getContact()
    {
        if (Cache::has('Contact')){
            $maps = Cache::get('Contact');
        } else {
            $maps = Cache::remember('Contact', 60*60*24, function (){
                return Setting::all();
            });
        }
        return  $maps->first();
    }
}

if (! function_exists('hasRoleOrPermission')) {
    function hasRoleOrPermission($role)
    {
        $permissionRouteTitle = str_replace('.', '-', $role);
        $locale = App::getLocale();
        if (Auth::user()->can($permissionRouteTitle)){
            return true;
        }else{
            return redirect()->action( 'Admin\DashboardController@index', 'en');
        }
    }
}

if (! function_exists('int_value')) {
    function int_value($id)
    {
        $new_string = preg_replace("/[^A-Za-z0-9?!]/",'',$id);
        return intval($new_string);
    }
}

if (! function_exists('getPageById')) {
    function getPageById($id){
        if (Cache::has('Page')){
            $page = Cache::get('Page')->where('status', '1')->find($id);
        } else {
            $pages = Cache::remember('Page', 60*60*24, function (){
                return Page::with('seo','rowParent')->get();
            });
            $page = Cache::get('Page')->where('status', '1')->find($id);
        }
        return $page;
    }
}

if (! function_exists('clean')) {
    function clean($str){
        $str = str_replace("&nbsp;", " ", $str);
        $str = str_replace("&amp;", "&", $str);
        $str = preg_replace('/\s+/', ' ',$str);
        $str = trim($str);
        return $str;
    }
}

if (! function_exists('array_sort_recursive')) {
    function array_sort_recursive($array): array
    {
        return Arr::sortRecursive($array);
    }
}


if (!function_exists('getTranslationValues')) {
    /**
     * Get values for a specific key from multiple translation files.
     *
     * @param string $key The key whose value you want to retrieve.
     * @param array $languages Array of language codes.
     * @return array An associative array of language codes and their corresponding values.
     */
    function getTranslationValues(string $key): array
    {
        $values = [];
        $languages = Locale::groupBy('code')->pluck('code')->toArray();
        foreach ($languages as $lang) {
            $filePath = resource_path("lang/{$lang}.json");

            if (file_exists($filePath)) {
                $jsonContent = json_decode(file_get_contents($filePath), true);

                if (isset($jsonContent[$key])) {
                    $values[$lang] = $jsonContent[$key];
                } else {
                    $values[$lang] = null; // Key doesn't exist in the file
                }
            } else {
                $values[$lang] = null; // File doesn't exist
            }
        }

        return $values;
    }
}
