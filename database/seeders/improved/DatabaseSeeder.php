<?php

namespace Database\Seeders\Improved;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database using improved seeders.
     */
    public function run(): void
    {
        $this->call([
            LocaleSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            AdminUserSeeder::class,
            FolderSeeder::class
        ]);
    }
} 