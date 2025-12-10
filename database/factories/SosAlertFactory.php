<?php

namespace Database\Factories;

use App\Models\SosAlert;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SosAlert>
 */
class SosAlertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'message' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['Open', 'Closed']),
        ];
    }
}
