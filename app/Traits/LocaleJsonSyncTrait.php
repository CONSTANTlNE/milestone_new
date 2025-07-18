<?php

namespace App\Traits;

use App\Models\Locale;

trait LocaleJsonSyncTrait
{
    /**
     * Update the lang/config_locales.json file to match the current active locales in the database.
     */
    public function updateLocalesJsonFile(): void
    {
        $locales = Locale::where('status', 1)
            ->orderBy('position', 'asc')
            ->get(['code', 'title', 'script', 'native', 'regional']);
        $supportedLocales = [];
        foreach ($locales as $locale) {
            $supportedLocales[$locale->code] = [
                'name'     => $locale->title,
                'script'   => $locale->script,
                'native'   => $locale->native ?? $locale->title,
                'regional' => $locale->regional,
            ];
        }
        file_put_contents(
            lang_path('config_locales.json'),
            json_encode($supportedLocales, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
} 