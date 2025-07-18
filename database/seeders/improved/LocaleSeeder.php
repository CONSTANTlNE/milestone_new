<?php

namespace Database\Seeders\Improved;

use App\Models\Locale;
use Illuminate\Database\Seeder;

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
     */
    public function run(): void
    {
        $localesJson = [];
        foreach ($this->locales as $locale) {
            Locale::updateOrCreate(
                [
                    'code' => $locale['code']
                ],
                $locale
            );
            $localesJson[$locale['code']] = $locale['name'];
        }
        // Write locales.json in lang folder
        $langPath = base_path('lang/locales.json');
        file_put_contents($langPath, json_encode($localesJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
} 