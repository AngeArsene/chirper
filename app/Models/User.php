<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property-read string $password
 * @property-read string|null $remember_token
 * @property-read Carbon|null $created_at
 * @property-read Carbon|null $updated_at
 * @property-read Collection<int, Chirp> $chirps
 * @property-read int|null $chirps_count
 */
#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the chirps owned by the user.
     *
     * @return HasMany<Chirp>
     */
    public function chirps(): HasMany
    {
        return $this->hasMany(Chirp::class);
    }

    /**
     * Get the chirp likes owned by the user.
     *
     * @return HasMany<ChirpLike>
     */
    public function chirpLikes(): HasMany
    {
        return $this->hasMany(ChirpLike::class);
    }

    /**
     * Like a chirp.
     */
    public function likeChirp(Chirp $chirp): void
    {
        $this->chirpLikes()->create(['chirp_id' => $chirp->id]);
    }

    /**
     * Unlike a chirp.
     */
    public function unlikeChirp(Chirp $chirp): void
    {
        $this->chirpLikes()->where('chirp_id', $chirp->id)->delete();
    }

    /**
     * Check if the user has liked a chirp.
     */
    public function hasLikedChirp(Chirp $chirp): bool
    {
        return $this->chirpLikes()->where('chirp_id', $chirp->id)->exists();
    }
}
