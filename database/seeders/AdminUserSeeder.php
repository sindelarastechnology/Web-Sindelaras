<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@sindelarastechnology.my.id'],
            [
                'name'     => 'Admin Sindelaras',
                'email'    => 'admin@sindelarastechnology.my.id',
                'password' => Hash::make('SindelarasAdmin2024!'),
            ]
        );

        $user->assignRole('super_admin');
    }
}
