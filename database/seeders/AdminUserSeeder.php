<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Teka',
            'lastname' => 'Jo', // Provide a value for lastname
            'phone' => '1234567890',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}