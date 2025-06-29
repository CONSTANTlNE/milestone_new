<?php

namespace Database\Seeders;

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
                    "ka" => "სუპერ ადმინისტრატორი",
                    "en" => "Super Admin"
                ],
                'permissions' => $permissions['super'] ?? [],
            ],
            'Admin' => [
                'guard_name' => 'web',
                'title' => [
                    "ka" => "ადმინ იუზერი",
                    "en" => "Admin User"
                ],
                'permissions' => $permissions['admin'] ?? [],
            ],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        array_walk($this->roles, function ($roleContent, $roleName) {
            $role = Role::firstOrCreate(
                [
                    'name' => $roleName,
                    'guard_name' => $roleContent['guard_name'],
                ],
                [
                    'title' => $roleContent['title'],
                ]
            );

            $role->syncPermissions($roleContent['permissions']);
        });
    }
}
