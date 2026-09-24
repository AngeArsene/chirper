<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'avatar' => $this->avatarUrl(),
            'cover' => $this->coverUrl(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make(config('app.default_user_password')), // Default password for testing
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $_attributes) => [
            'email_verified_at' => null,
        ]);
    }

    private function avatarUrl(): ?string
    {
        if (fake()->boolean()) {
            $uuid = fake()->uuid();
            $response = Http::get("https://i.pravatar.cc/256?u=$uuid");

            if ($response->successful()) {
                $filename = "avatars/$uuid.jpg";
                Storage::disk('public')->put($filename, $response->body());

                return $filename; // just the relative path, matching the controller
            }
        }

        return null;
    }

    private function coverUrl(): ?string
    {
        if (fake()->boolean()) {
            $uuid = fake()->uuid();
            $response = Http::get("https://picsum.photos/seed/chirper-$uuid/1200/400");

            if ($response->successful()) {
                $filename = "covers/$uuid.jpg";
                Storage::disk('public')->put($filename, $response->body());

                return $filename; // just the relative path, matching the controller
            }
        }

        return null;
    }
}
