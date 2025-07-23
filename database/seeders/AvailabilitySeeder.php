<?php

namespace Database\Seeders;

use App\Models\Availability;
use Illuminate\Database\Seeder;

class AvailabilitySeeder extends Seeder
{
    private array $avilabilities = ['as soon as possible','within 2 weeks', 'within 30 days','more than 30 days'];
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        array_map(function ($availability) {
            Availability::create([
                'title' => [
                    'en' => $availability,
                ],
            ]);
        }, $this->avilabilities);
    }
}
