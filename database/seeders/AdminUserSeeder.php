<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    private array $users = [
        [
            "title" => [
                "ka" => "ბორის ბარაბაძე",
                "en" => "Boris Barabadze"
            ],
            'name' => 'Boris Barabadze',
            'email' => 'borisi.barabadze@gmail.com',
            'password' => '12345679',
            'role' => 'Super Admin'
        ],
        [
            "title" => [
                "ka" => "კოსტანტინე ალავერდაშვილი",
                "en" => "Constantine Alaverdashvili"
            ],
            'name' => 'Constantine Alaverdashvili',
            'email' => 'gmta.constantine@gmail.com',
            'password' => '12345679',
            'role' => 'Admin'
        ],
        [
            "title" => [
                "ka" => "ბადრი გოგილაშვილი",
                "en" => "Badri Gogilashvili"
            ],
            'name' => 'Badri Gogilashvili',
            'email' => 'manager@gmail.com',
            'password' => '12345679',
            'role' => 'Admin'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        array_map(function ($user) {
            $userWithoutRole = array_splice($user, 0, 4);
            $admin = User::firstOrCreate(
                [
                    'email' => $userWithoutRole['email']
                ],
                [
                    'title' => $userWithoutRole['title'],
                    'name' => $userWithoutRole['name'],
                    'password' => Hash::make($userWithoutRole['password']),
                ]
            );
            $admin->syncRoles($user['role']);
        }, $this->users);
    }
}
