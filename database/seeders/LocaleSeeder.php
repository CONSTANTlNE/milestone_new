<?php

namespace Database\Seeders;

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
     *
     * @return void
     */
    public function run()
    {
        array_map(function ($locale) {
            Locale::firstOrCreate([
                'name' => $locale['name'],
                'native' => $locale['native'],
                'status' => $locale['status'],
                'code' => $locale['code'],
                'default' => $locale['default'],
                'position' => $locale['position']
            ]);

            $data = openJSONFile('locales');
            $data[$locale['code']] = $locale['name'];
            saveJSONFile('locales', $data);

            $data[$locale['code']] = $locale['name'];
            saveJSONFile($locale['code'], $data);

        }, $this->locales);
    }
}
