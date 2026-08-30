<?php

namespace Database\Seeders;

use App\Models\Chirp;
use App\Models\ChirpBookmark;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChirpBookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Chirp::each(function (Chirp $chirp) use ($users) {
            $count = random_int(0, $users->count());

            if ($count === 0) {
                return;
            }

            $randomUsers = $users->random($count);

            $randomUsers->each(
                fn(User $randomUser) => ChirpBookmark::factory()
                    ->for($randomUser)
                    ->for($chirp)
                    ->create()
            );
        });
    }
}
