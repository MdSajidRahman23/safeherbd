<?php

namespace Database\Seeders;

use App\Models\SafeRoute;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SafeRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user for created_by
        $admin = User::where('is_admin', true)->first();

        // Sample safe routes in Dhaka, Bangladesh
        $routes = [
            [
                'route_name' => 'Gulshan to Dhanmondi Safe Route',
                'coordinates' => [
                    [23.7925, 90.4078], // Gulshan
                    [23.7461, 90.3742], // Dhanmondi
                ],
                'total_score' => 3, // Very safe
                'theft_count' => 1,
                'robbery_count' => 0,
                'kidnapping_count' => 0,
                'created_by' => $admin->id ?? 1,
            ],
            [
                'route_name' => 'Uttara to Mirpur Route',
                'coordinates' => [
                    [23.8759, 90.3794], // Uttara
                    [23.8223, 90.3654], // Mirpur
                ],
                'total_score' => 7, // Moderately safe
                'theft_count' => 3,
                'robbery_count' => 1,
                'kidnapping_count' => 0,
                'created_by' => $admin->id ?? 1,
            ],
            [
                'route_name' => 'Mohammadpur to Banani',
                'coordinates' => [
                    [23.7574, 90.3609], // Mohammadpur
                    [23.7937, 90.4034], // Banani
                ],
                'total_score' => 12, // Moderate risk
                'theft_count' => 5,
                'robbery_count' => 2,
                'kidnapping_count' => 1,
                'created_by' => $admin->id ?? 1,
            ],
            [
                'route_name' => 'Old Dhaka to New Market',
                'coordinates' => [
                    [23.7104, 90.4074], // Old Dhaka
                    [23.7324, 90.3847], // New Market
                ],
                'total_score' => 18, // High risk
                'theft_count' => 8,
                'robbery_count' => 4,
                'kidnapping_count' => 2,
                'created_by' => $admin->id ?? 1,
            ],
            [
                'route_name' => 'Bashundhara to Kuril',
                'coordinates' => [
                    [23.8197, 90.4522], // Bashundhara
                    [23.8293, 90.4203], // Kuril
                ],
                'total_score' => 2, // Very safe
                'theft_count' => 0,
                'robbery_count' => 0,
                'kidnapping_count' => 0,
                'created_by' => $admin->id ?? 1,
            ],
            [
                'route_name' => 'Wari to Sadarghat',
                'coordinates' => [
                    [23.7181, 90.4181], // Wari
                    [23.7047, 90.4203], // Sadarghat
                ],
                'total_score' => 25, // High risk
                'theft_count' => 12,
                'robbery_count' => 6,
                'kidnapping_count' => 3,
                'created_by' => $admin->id ?? 1,
            ],
        ];

        foreach ($routes as $route) {
            SafeRoute::create($route);
        }
    }
}
