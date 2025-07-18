<?php

namespace Database\Seeders\Improved;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    private array $users = [
        [
            'title' => [
                'ka' => 'ბორის ბარაბაძე',
                'en' => 'Boris Barabadze'
            ],
            'name' => 'Boris Barabadze',
            'email' => 'borisi.barabadze@gmail.com',
            'password' => '12345679',
            'role' => 'Super Admin'
        ],
        [
            'title' => [
                'ka' => 'კოსტანტინე ალავერდაშვილი',
                'en' => 'Constantine Alaverdashvili'
            ],
            'name' => 'Constantine Alaverdashvili',
            'email' => 'gmta.constantine@gmail.com',
            'password' => '12345679',
            'role' => 'Admin'
        ],
        [
            'title' => [
                'ka' => 'ბადრი გოგილაშვილი',
                'en' => 'Badri Gogilashvili'
            ],
            'name' => 'Badri Gogilashvili',
            'email' => 'manager@gmail.com',
            'password' => '12345679',
            'role' => 'Admin'
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->users as $user) {
            $admin = User::updateOrCreate(
                [
                    'email' => $user['email']
                ],
                [
                    'title' => $user['title'],
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                ]
            );
            $admin->syncRoles($user['role']);
        }
    }
} 