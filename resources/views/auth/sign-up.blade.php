<x-layouts.main>
    <div class="hero min-h-[calc(100vh-16rem)]">
        <div class="hero-content flex-col">
            <div class="card w-96 bg-base-100">
                <div class="card-body">
                    <h1 class="text-xl mt-1 font-bold text-center mb-6">{{ __('Create Account') }}</h1>

                    <form method="POST" action="{{ route('auth.register') }}">
                        @csrf
                        @method('POST')

                        <!-- Name -->
                        <label class="floating-label mb-6">
                            <input type="text" name="name" placeholder="Ex: John Doe" value="{{ old('name') }}"
                                class="input input-bordered @error('name') input-error @enderror" maxlength="255"
                                minlength="4" required>
                            <span>{{ __('Name') }}</span>
                        </label>
                        @error('name')
                            <div class="label -mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ __($message) }}</span>
                            </div>
                        @enderror

                        <!-- Email -->
                        <label class="floating-label mb-6">
                            <input type="email" name="email" placeholder="Ex: mail@example.com"
                                value="{{ old('email') }}"
                                class="input input-bordered @error('email') input-error @enderror" required>
                            <span>{{ __('Email') }}</span>
                        </label>
                        @error('email')
                            <div class="label -mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ __($message) }}</span>
                            </div>
                        @enderror

                        <!-- Password -->
                        <x-password-field />

                        <!-- Password Confirmation -->
                        <label class="floating-label mb-6">
                            <input type="password" name="password_confirmation" placeholder="••••••••"
                                class="input input-bordered" maxlength="255" minlength="8" required>
                            <span>{{ __('Confirm Password') }}</span>
                        </label>
                        @error('password_confirmation')
                            <div class="label -mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ __($message) }}</span>
                            </div>
                        @enderror

                        <!-- Submit Button -->
                        <div class="form-control mt-8">
                            <button type="submit" class="btn btn-primary btn-sm w-full">
                                {{ __('Register') }}
                            </button>
                        </div>

                        <!-- Accept Terms -->
                        <div class="form-control mt-4">
                            <label class="label cursor-pointer justify-start">
                                <input type="checkbox" name="accepted" class="checkbox" required>
                                <span class="label-text ml-2">{{ __('I accept the Terms and Conditions.') }}</span>
                            </label>

                            @error('accepted')
                                <div class="label -mt-4 mb-2">
                                    <span class="label-text-alt text-error">{{ __($message) }}</span>
                                </div>
                            @enderror
                        </div>
                    </form>

                    <div class="divider">{{ __('OR') }}</div>
                    <p class="text-center text-sm">
                        {{ __('Already have an account?') }}
                        <a href="{{ route('auth.sign-in') }}" class="link link-primary">{{ __('Sign in') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
