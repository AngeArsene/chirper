<x-layouts.profile :user="auth()->user()">
    {{-- Password form --}}
    <form method="POST" action="{{ route('profile.password.update') }}">
        @csrf
        @method('PATCH')

        {{-- Current Password --}}
        <label class="floating-label mb-6">
            <input type="password" name="current_password" placeholder="Current password"
                class="input input-bordered @error('current_password') input-error @enderror" required
                maxlength="255" minlength="4" autofocus>
            <span>{{ __('Current password') }}</span>
        </label>

        @error('current_password')
            <div class="label -mt-4 mb-2">
                <span class="label-text-alt text-error">{{ __($message) }}</span>
            </div>
        @enderror

        <!-- Password -->
        <x-password-field placeholder='New Password' />

        <!-- Password Confirmation -->
        <label class="floating-label mb-6">
            <input type="password" name="password_confirmation" placeholder="{{ __('Confirm Password') }}"
                class="input input-bordered" maxlength="255" minlength="8" required>
            <span>{{ __('Confirm Password') }}</span>
        </label>
        @error('password_confirmation')
            <div class="label -mt-4 mb-2">
                <span class="label-text-alt text-error">{{ __($message) }}</span>
            </div>
        @enderror

        {{-- Submit --}}
        <div class="form-control" onclick="return confirm('Are you sure you want to change your password?')">
            <button type="submit" class="btn btn-primary btn-sm w-full">
                {{ __('Save changes') }}
            </button>
        </div>
    </form>
</x-layouts.profile>
