<?php
namespace App\Services;

use Illuminate\Support\Str;
use App;
use Illuminate\Support\Facades\Session;
use App\Models\Locale;
use Illuminate\Support\Facades\Cache;

class LanguageConfigService
{
    /**
     * Cached copy of the configured supported locales
     *
     * @var string
     */
    protected static $configuredSupportedLocales = [];

    /**
     * Our instance of the Laravel app
     *
     * @var Illuminate\Foundation\Application
     */
    protected $app = '';

    /**
     * General TTL for cached items.
     */

    const CACHE_TTL = 86400; // 1 day

    /**
     * Make a new Locale instance
     *
     * @param Illuminate\Foundation\Application $app
     */
    public function __construct($app = '')
    {
        $this->app = $app;
    }


    /**
     * Retrieve the currently set locale
     *
     * @return string
     */
    public function current()
    {
        return $this->app->getLocale();
    }


    /**
     * Retrieve the configured fallback locale
     *
     * @return string
     */
    public function fallback()
    {
        $langDefaut = Locale::where('status','1')->where('default','1')->first();
        return $langDefaut->code;
    }

    /**
     * Set the current locale
     *
     * @param string $locale
     */
    public function set($locale)
    {
        $this->app->setLocale($locale);
    }


    /**
     * Retrieve the current locale's directionality
     *
     * @return string
     */
    public function dir()
    {
        return $this->getConfiguredSupportedLocales()[$this->current()]['dir'];
    }

    /**
     * Retrieve the name of the current locale in the app's
     * default language
     *
     * @return string
     */
    public function nameFor($locale)
    {
        return $this->getConfiguredSupportedLocales()[$locale]['name'];
    }


    /**
     * Retrieve all of our app's supported locale language keys
     *
     * @return array
     */
    public function supported()
    {
        return array_keys($this->getConfiguredSupportedLocales());
    }


    /**
     * Determine whether a locale is supported by our app
     * or not
     *
     * @return boolean
     */
    public function isSupported($locale)
    {
        return in_array($locale, $this->supported());
    }


    /**
     * Retrieve our app's supported locale's from configuration
     *
     * @return array
     */
    protected function getConfiguredSupportedLocales()
    {
        // cache the array for calls
//        $languages = Cache::remember('languages', self::CACHE_TTL, function (){
//            $items = Locale::groupBy('code')->pluck('code')->toArray();
//            return array_flip($items);
//        });
        $items = Locale::groupBy('code')->pluck('code')->toArray();
        $languages = array_flip($items);
        if (empty(static::$configuredSupportedLocales)) {
            static::$configuredSupportedLocales = $languages;
        }

        return static::$configuredSupportedLocales;
    }
}
