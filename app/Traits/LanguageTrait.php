<?php

namespace App\Traits;

use App\Models\Locale;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Support\Env;
use App\Exceptions\SupportedLocalesNotDefined;
use App\Exceptions\UnsupportedLocaleException;
use App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

trait LanguageTrait
{
    /**
     * Cached copy of the configured supported locales
     *
     * @var string|array
     */
    protected static string|array $configuredSupportedLocales = [];

    /**
     * Illuminate request class.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Illuminate router class.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * Illuminate request class.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * Illuminate url class.
     *
     * @var \Illuminate\Contracts\Routing\UrlGenerator
     */
    protected $url;

    public function __construct(
        Application $app,
        Router $router,
        Request $request,
        UrlGenerator $url
    )
    {
        $this->app = $app;
        $this->router = $router;
        $this->request = $request;
        $this->url = $url;
    }

    /**
     * Retrieve the currently set locale
     *
     * @return string
     */
    public function current(): string
    {
        return $this->app->getLocale();
    }


    /**
     * Retrieve the configured fallback locale
     *
     * @return string
     */
    public function fallback(): string
    {
        $langDefaut = Locale::where('status','1')->where('default','1')->first();
        return $langDefaut->code ?? 'en';
    }

    /**
     * Set the current locale
     *
     * @param string $locale
     */
    public function set($locale): void
    {
        $this->app->setLocale($locale);
    }


    /**
     * Retrieve the current locale's directionality
     *
     * @return string
     */
    public function dir(): string
    {
        return $this->getConfiguredSupportedLocales()[$this->current()]['dir'];
    }

    /**
     * Retrieve the name of the current locale in the app's
     * default language
     *
     * @param $locale
     * @return string
     */
    public function nameFor($locale): string
    {
        return $this->getConfiguredSupportedLocales()[$locale]['name'];
    }


    /**
     * Retrieve all of our app's supported locale language keys
     *
     * @return array
     */
    public function supported(): array
    {
        return array_keys($this->getConfiguredSupportedLocales());
    }


    /**
     * Determine whether a locale is supported by our app
     * or not
     *
     * @param $locale
     * @return boolean
     */
    public function isSupported($locale): bool
    {
        return in_array($locale, $this->supported());
    }


    /**
     * Retrieve our app's supported locale's from configuration
     *
     * @return array
     */
    protected function getConfiguredSupportedLocales(): array
    {
        $languages = array_flip(getLocalesCode());
        if (empty(static::$configuredSupportedLocales)) {
            static::$configuredSupportedLocales = $languages;
        }

        return static::$configuredSupportedLocales;
    }
}
