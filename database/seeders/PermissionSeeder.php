<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    private array $permissions = [
        [
            "title" => [
                "ka" => "დაშბოარდის ნახვა",
                "en" => "View Dashboard"
            ],
            "guard_name" => "web",
            "name" => "backend.dashboard.index"
        ],
        [
            "title" => [
                "ka" => "ადმინისტრატორების ნახვა",
                "en" => "View Admin"
            ],
            "guard_name" => "web",
            "name" => "backend.users.index"
        ],
        [
            "title" => [
                "ka" => "ადმინისტრატორების შექმნა",
                "en" => "Creating Admin"
            ],
            "guard_name" => "web",
            "name" => "backend.users.create"
        ],
        [
            "title" => [
                "ka" => "ადმინისტრატორების შენახვა",
                "en" => "Store Admin"
            ],
            "guard_name" => "web",
            "name" => "backend.users.store"
        ],
        [
            "title" => [
                "ka" => "ადმინისტრატორების შეცვლა",
                "en" => "Edit Admin"
            ],
            "guard_name" => "web",
            "name" => "backend.users.edit"
        ],
        [
            "title" => [
                "ka" => "ადმინისტრატორების განახლება",
                "en" => "Update Admin"
            ],
            "guard_name" => "web",
            "name" => "backend.users.update"
        ],
        [
            "title" => [
                "ka" => "ადმინისტრატორების წაშლა",
                "en" => "Delete Admin"
            ],
            "guard_name" => "web",
            "name" => "backend.users.destroy"
        ]
    ];
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
