<?php

namespace Database\Seeders;

use App\Models\Locale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LocaleSeeder extends Seeder
{
    private array $locales = [
        [
            'name' => 'ქართული',
            'native' => 'ka_GE',
            'code' => 'ka',
            'status' => 1,
            'default' => 1,
            'position' => 1
        ],
        [
            'name' => 'English',
            'native' => 'en_EN',
            'code' => 'en',
            'status' => 1,
            'default' => 0,
            'position' => 2
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        array_map(function ($locale) {
            Locale::firstOrCreate([
                'title' => $locale['name'],
                'native' => $locale['native'],
                'status' => $locale['status'],
                'code' => $locale['code'],
                'position' => $locale['position']
            ]);

            $data = openJSONFile('locales');
            $data[$locale['code']] = $locale['name'];
            saveJSONFile('locales', $data);

            $data[$locale['code']] = $locale['name'];
            saveJSONFile($locale['code'], $data);

        }, $this->locales);

    // Seed the database
    foreach ($this->locales as $locale) {
        Locale::firstOrCreate([
            'title' => $locale['name'],
            'native' => $locale['native'],
            'status' => $locale['status'],
            'code' => $locale['code'],
            'position' => $locale['position']
        ]);
    }

        // Prepare data for locales.json
        $localesData = [];
        foreach ($this->locales as $locale) {
            $localesData[$locale['code']] = $locale['name'];
        }

    // Save to resources/lang/config_locales.json (or wherever you want)
    $jsonPath = lang_path('locales.json');
    File::put($jsonPath, json_encode($localesData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        // Save to lang/config_locales.json
        $configLocalesData = [];
        foreach ($this->locales as $locale) {
            $configLocalesData[$locale['code']] = [
                'name' => $locale['name'],
                'script' => null,
                'native' => $locale['native'],
                'regional' => null
            ];
        }
        $configPath = lang_path('config_locales.json');
        File::put($configPath, json_encode($configLocalesData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        // Initialize empty JSON files for each locale if they don't exist or are empty
        foreach ($this->locales as $locale) {
            $localePath = lang_path("{$locale['code']}.json");
            if (!File::exists($localePath) || File::size($localePath) <= 2) {
                File::put($localePath, json_encode([], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            }
        }
    }
}
