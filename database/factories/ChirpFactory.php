<?php

namespace Database\Factories;

use App\Models\Chirp;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Chirp>
 */
class ChirpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $created_at = $updated_at = fake()->dateTimeBetween('-1 week', 'now');

        return [
            'message' => fake()->realText(150),
            'idempotency_key' => fake()->unique()->uuid(),
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ];
    }
}
