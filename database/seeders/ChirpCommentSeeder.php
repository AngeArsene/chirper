<?php

namespace Database\Seeders;

use App\Models\Chirp;
use App\Models\ChirpComment;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChirpCommentSeeder extends Seeder
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

            $randomUsers = collect()->times($count, fn () => $users->random());

            $randomUsers->each(
                fn (User $randomUser) => ChirpComment::factory()
                    ->for($chirp)
                    ->for($randomUser)
                    ->create()
            );
        });
    }
}
