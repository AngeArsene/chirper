<?php

namespace Database\Seeders;

use App\Models\ChirpComment;
use App\Models\ChirpCommentLike;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChirpCommentLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        ChirpComment::each(function (ChirpComment $comment) use ($users) {
            $count = random_int(0, $users->count());

            if ($count === 0) {
                return;
            }

            $users->random($count)->each(
                fn(User $randomUser) => ChirpCommentLike::factory()
                    ->for($randomUser)
                    ->for($comment)
                    ->create()
            );
        });
    }
}
