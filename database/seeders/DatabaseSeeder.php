<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@safeher.local',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_admin' => true,
            'gender' => 'female',
        ]);

        // Create test woman user
        User::factory()->create([
            'name' => 'Test Woman',
            'email' => 'woman@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'is_admin' => false,
            'gender' => 'female',
        ]);

        // Create test user with other gender
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'is_admin' => false,
            'gender' => 'male',
        ]);

        // Create more random users
        User::factory(5)->create([
            'role' => 'user',
            'is_admin' => false,
        ]);

        // Seed safe routes
        $this->call([
            SafeRouteSeeder::class,
        ]);
    }
}
