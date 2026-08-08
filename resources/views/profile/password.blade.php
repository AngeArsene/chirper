<x-layouts.main>
    <div class="hero min-h-[calc(100vh-16rem)]">
        <div class="hero-content flex-col w-full max-w-xl">

            <div class="card w-full bg-base-100">
                <div class="card-body">

                    {{-- Avatar + heading --}}
                    <div class="flex flex-col items-center gap-3 mb-6">
                        <div class="avatar">
                            <div class="size-16 rounded-full">
                                <img src="https://avatars.laravel.cloud/{{ urlencode(auth()->user()->email) }}?vibe=ocean"
                                    alt="{{ auth()->user()->name }}'s avatar" class="rounded-full" />
                            </div>
                        </div>
                        <h1 class="text-xl font-bold">{{ auth()->user()->name }}</h1>
                        <span class="text-sm text-base-content/60">{{ auth()->user()->email }}</span>
                    </div>

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

                </div>
            </div>

        </div>
    </div>
</x-layouts.main>
