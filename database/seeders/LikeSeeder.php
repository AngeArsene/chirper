<?php

namespace Database\Seeders;

use App\Models\Chirp;
use App\Models\ChirpComment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $this->seedLikesFor(Chirp::query(), $users);
        $this->seedLikesFor(ChirpComment::query(), $users);
    }

    /**
     * Seeds likes for the given likeable models and users.
     *
     * @param  Builder  $likeables  The query builder for the likeable models.
     * @param  Collection  $users  The collection of users to randomly assign likes from.
     */
    private function seedLikesFor(Builder $likeables, Collection $users): void
    {
        $likeables->each(function (Model $likeable) use ($users) {
            $count = random_int(0, $users->count());

            if ($count === 0) {
                return;
            }

            $users->random($count)->each(
                fn (User $randomUser) => Like::factory()
                    ->for($randomUser)
                    ->for($likeable, 'likeable')
                    ->create()
            );
        });
    }
}
