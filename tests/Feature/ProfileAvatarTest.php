<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ProfileAvatarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_guest_users_are_redirected_to_login_and_no_avatar_file_is_stored(): void
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->from(route('profile.edit'))
            ->put(route('profile.avatar.update'), ['avatar' => $file]);

        $response->assertRedirect(route('auth.sign-in'));
        Storage::disk('public')->assertMissing('avatars');
    }

    public function test_first_upload_stores_the_avatar_under_avatars_with_a_uuid_filename_and_original_extension(): void
    {
        $user = User::factory()->create(['avatar' => null]);
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)
            ->from(route('profile.edit'))
            ->put(route('profile.avatar.update'), ['avatar' => $file]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'User avatar profile updated successfully.');

        $user->refresh();

        $this->assertMatchesRegularExpression('/^avatars\/[0-9a-f-]+\.jpg$/', $user->avatar);
        Storage::disk('public')->assertExists($user->avatar);
    }

    public function test_replacing_an_avatar_removes_the_old_file_and_saves_the_new_path_to_the_user(): void
    {
        $user = User::factory()->create();

        $oldPath = 'avatars/old-avatar.jpg';
        Storage::disk('public')->put($oldPath, 'old-avatar');
        $user->update(['avatar' => $oldPath]);

        $newFile = UploadedFile::fake()->image('new-avatar.png');

        $response = $this->actingAs($user)
            ->from(route('profile.edit'))
            ->put(route('profile.avatar.update'), ['avatar' => $newFile]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'User avatar profile updated successfully.');

        $user->refresh();

        $this->assertNotSame($oldPath, $user->avatar);
        $this->assertMatchesRegularExpression('/^avatars\/[0-9a-f-]+\.png$/', $user->avatar);

        Storage::disk('public')->assertExists($user->avatar);
        Storage::disk('public')->assertMissing($oldPath);
    }

    public function test_a_storage_failure_keeps_the_old_avatar_and_redirects_back_with_an_avatar_error(): void
    {
        $user = User::factory()->create();

        $oldPath = 'avatars/old-avatar.jpg';
        Storage::disk('public')->put($oldPath, 'old-avatar');
        $user->update(['avatar' => $oldPath]);

        $file = UploadedFile::fake()->image('new-avatar.jpg');
        $mockedFile = Mockery::mock($file)->makePartial();
        $mockedFile->shouldReceive('storeAs')
            ->once()
            ->with('avatars', Mockery::type('string'), 'public')
            ->andReturn(false);

        $response = $this->actingAs($user)
            ->from(route('profile.show'))
            ->put(route('profile.avatar.update'), ['avatar' => $mockedFile]);

        $response->assertRedirect()
            ->assertSessionHasErrors('avatar');

        $user->refresh();
        $this->assertSame($oldPath, $user->avatar);
        Storage::disk('public')->assertExists($oldPath);
        Storage::disk('public')->assertMissing('avatars/new-avatar.jpg');
    }

    public function test_old_file_delete_failure_is_not_reliably_testable_in_http_flow(): void
    {
        $this->markTestSkipped('The controller never reports or logs delete failures, so there is no observable HTTP behavior to assert beyond the saved new path and success redirect.');
    }

    #[DataProvider('invalidAvatarProvider')]
    public function test_invalid_avatar_uploads_return_a_validation_error_and_leave_the_database_unchanged(mixed $avatar): void
    {
        $user = User::factory()->create(['avatar' => null]);

        $response = $this->actingAs($user)
            ->from(route('profile.show'))
            ->put(route('profile.avatar.update'), ['avatar' => $avatar]);

        $response->assertSessionHasErrors('avatar');

        $user->refresh();
        $this->assertNull($user->avatar);

        if ($avatar === null) {
            $this->assertSame([], Storage::disk('public')->allFiles('avatars'));
        }
    }

    public static function invalidAvatarProvider(): array
    {
        return [
            'missing file' => [null],
            'non-image file' => [UploadedFile::fake()->create('document.pdf', 120, 'application/pdf')],
            'oversized image' => [UploadedFile::fake()->image('avatar.jpg')->size(1025)],
        ];
    }

    public function test_uploading_twice_in_a_row_with_the_same_extension_produces_two_different_filenames(): void
    {
        $user = User::factory()->create(['avatar' => null]);

        $firstFile = UploadedFile::fake()->image('avatar.jpg');
        $this->actingAs($user)
            ->from(route('profile.show'))
            ->put(route('profile.avatar.update'), ['avatar' => $firstFile]);

        $firstPath = $user->refresh()->avatar;

        $secondFile = UploadedFile::fake()->image('avatar.jpg');
        $this->actingAs($user)
            ->from(route('profile.show'))
            ->put(route('profile.avatar.update'), ['avatar' => $secondFile]);

        $secondPath = $user->refresh()->avatar;

        $this->assertNotSame($firstPath, $secondPath);
        $this->assertMatchesRegularExpression('/^avatars\/[0-9a-f-]+\.jpg$/', $firstPath);
        $this->assertMatchesRegularExpression('/^avatars\/[0-9a-f-]+\.jpg$/', $secondPath);

        Storage::disk('public')->assertMissing($firstPath);
        Storage::disk('public')->assertExists($secondPath);
    }
}
