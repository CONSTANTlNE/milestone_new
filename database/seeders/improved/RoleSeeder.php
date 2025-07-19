<?php

namespace Database\Seeders\Improved;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    private array $roles = [];

    public function __construct()
    {
        $permissions = include database_path('seeders/data/permissions_for_roles.php');
        $this->roles = [
            'Super Admin' => [
                'guard_name' => 'web',
                'title' => [
                    'ka' => 'სუპერ ადმინისტრატორი',
                    'en' => 'Super Admin'
                ],
                'permissions' => $permissions['super'] ?? [],
            ],
            'Admin' => [
                'guard_name' => 'web',
                'title' => [
                    'ka' => 'ადმინ იუზერი',
                    'en' => 'Admin User'
                ],
                'permissions' => $permissions['admin'] ?? [],
            ],
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->roles as $roleName => $roleContent) {
            $role = Role::updateOrCreate(
                [
                    'name' => $roleName,
                    'guard_name' => $roleContent['guard_name'],
                ],
                [
                    'title' => $roleContent['title'],
                ]
            );
            if (isset($roleContent['permissions']) && is_array($roleContent['permissions'])) {
                $role->syncPermissions($roleContent['permissions']);
            }
        }
    }
} 