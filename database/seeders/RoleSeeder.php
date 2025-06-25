<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{

    private array $roles = [
        'Admin' => [
            'guard_name' => 'web',
            'title' => [
                "ka" => "ადმინ იუზერი",
                "en" => "Admin User"
            ],
            'permissions' => [
                'backend.dashboard.index',
                'backend.users.index',
                'backend.users.create',
                'backend.users.store',
                'backend.users.edit',
                'backend.users.update',
                'backend.users.destroy'
            ]
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $x = [
            "ka" => "სუპერ ადმინისტრატორი",
            "en" => "Super Admin"
        ];
        //Super Admin Role
        Role::updateOrCreate(
            [
                'name' => 'Super Admin',
                'guard_name' => 'web'
            ],
            [
                'title' => json_encode($x, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            ]
        );

        array_walk($this->roles, function ($roleContent, $roleName) {
            $role = Role::firstOrCreate(
                [
                    'name' => $roleName,
                    'guard_name' => $roleContent['guard_name'],
                ],
                [
                    'title' => json_encode($roleContent['title'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                ]
            );

            $role->syncPermissions($roleContent['permissions']);
        });
    }
}
