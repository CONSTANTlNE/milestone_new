<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LocaleSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            AdminUserSeeder::class,
            SettingSeeder::class,
            FolderSeeder::class,
            AvailabilitySeeder::class
        ]);
    }
}
