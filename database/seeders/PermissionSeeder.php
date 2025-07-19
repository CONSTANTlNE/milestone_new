<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    private array $permissions;

    public function __construct()
    {
        $this->permissions = include database_path('seeders/data/permissions.php');
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        array_map(function ($permission) {
            Permission::firstOrCreate(
                [
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name'],
                ],
                [
                    'title' => $permission['title']
                ]
             );
        }, $this->permissions);
    }
}
