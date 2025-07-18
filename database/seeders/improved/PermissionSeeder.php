<?php

namespace Database\Seeders\Improved;

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
     */
    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            if (!isset($permission['name'], $permission['guard_name'], $permission['title'])) {
                continue; // skip invalid
            }
            Permission::updateOrCreate(
                [
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name'],
                ],
                [
                    'title' => $permission['title']
                ]
            );
        }
    }
} 