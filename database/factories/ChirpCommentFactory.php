<?php

namespace Database\Factories;

use App\Models\ChirpComment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ChirpComment>
 */
class ChirpCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $created_at = $updated_at = fake()->dateTimeBetween('-1 hour', 'now');

        return [
            'message' => fake()->realText(75),
            'idempotency_key' => fake()->unique()->uuid(),
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ];
    }
}
