<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'lastname' => 'Test User2',
            'phone' => '11111111',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'John',
            'lastname' => 'Doe',
            'phone' => '1234567890',
            'email' => 'john.doe2@example.com',
            'password' => bcrypt('password'),
            'is_reviewer' => true,
        ]);
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}
