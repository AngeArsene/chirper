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
        $date_created_and_updated = fake()->dateTimeBetween('-1 year', 'now');

        return [
            'message' => fake()->realText(200),
            'idempotency_key' => fake()->unique()->uuid(),
            'created_at' => $date_created_and_updated,
            'updated_at' => $date_created_and_updated,
        ];
    }
}
