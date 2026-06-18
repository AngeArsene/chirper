<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChirpTest extends TestCase
{
    use RefreshDatabase;

    public function test_duplicate_submission_with_same_idempotency_key_fails_validation(): void
    {
        $user = User::factory()->create();

        $payload = [
            'message' => 'Hi, Everyone!',
            'idempotency_key' => '550e8400-e29b-41d4-a716-446655440000',
        ];

        $this->actingAs($user)
            ->post(route('chirps.store'), $payload)
            ->assertRedirect(route('chirps.index'))
            ->assertSessionHas('success', 'Your chirp has been posted!');

        $this->actingAs($user)
            ->post(route('chirps.store'), $payload)
            ->assertSessionHasErrors('idempotency_key');
    }

    public function test_existing_chirp_is_not_duplicated_when_same_idempotency_key_is_reused(): void
    {
        $user = User::factory()->create();

        $payload = [
            'message' => 'Hi, Everyone!',
            'idempotency_key' => '550e8400-e29b-41d4-a716-446655440000',
        ];

        $this->actingAs($user)
            ->post(route('chirps.store'), $payload);

        $this->assertDatabaseCount('chirps', 1);
        $this->assertDatabaseHas('chirps', [
            'user_id' => $user->id,
            'idempotency_key' => '550e8400-e29b-41d4-a716-446655440000',
        ]);
    }
}
