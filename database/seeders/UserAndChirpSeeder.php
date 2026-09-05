<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserAndChirpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->hasChirps(5)
            ->create([
                'name' => config('app.default_user_name'),
                'email' => config('app.default_user_email'),
                'password' => config('app.default_user_password'),
            ]);

        User::factory(19)->hasChirps(5)->create();
    }
}
