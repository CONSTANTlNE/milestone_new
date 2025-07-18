<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'title' => ['en' => 'Main Settings', 'ka' => 'მთავარი პარამეტრები'],
            'working_hours' => json_encode(['en' => 'Mon-Fri 9:00-18:00', 'ka' => 'ორშ-პარ 9:00-18:00']),
            'address' => json_encode(['en' => '123 Main St, Tbilisi', 'ka' => '123 მთავარი ქ., თბილისი']),
            'phone' => '+995 32 123 4567',
            'email' => 'info@example.com',
            'send_email' => 'noreply@example.com',
            'number_product_page' => 20,
            'lat' => '41.7151',
            'lng' => '44.8271',
            'g_map' => '<iframe src="https://maps.google.com/..." />',
            'g_analytics' => 'UA-XXXXX-Y',
            'fb_id' => '1234567890',
        ]);
    }
} 