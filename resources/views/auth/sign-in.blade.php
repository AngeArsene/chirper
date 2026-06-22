<x-layouts.main>
    <div class="hero min-h-[calc(100vh-16rem)]">
        <div class="hero-content flex-col">
            <div class="card w-96 bg-base-100">
                <div class="card-body">
                    <h1 class="text-xl mt-1 font-bold text-center mb-6">Welcome Back</h1>

                    <form method="POST" action="{{ route('auth.login') }}">
                        @csrf
                        @method('POST')

                        <!-- Email -->
                        <label class="floating-label mb-6">
                            <input type="email"
                                   name="email"
                                   placeholder="Ex: mail@example.com"
                                   value="{{ old('email') }}"
                                   class="input input-bordered @error('email') input-error @enderror"
                                   maxLength="255"
                                   required
                                   autofocus>
                            <span>{{ __('Email') }}</span>
                        </label>
                        @error('email')
                            <div class="label -mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <!-- Password -->
                        <label class="floating-label mb-2">
                            <input type="password"
                                   name="password"
                                   placeholder="••••••••"
                                   class="input input-bordered @error('password') input-error @enderror"
                                   minLength="8"
                                   maxLength="255"
                                   required>
                            <span>{{ __('Password') }}</span>
                        </label>
                        @error('password')
                            <div class="label -mt-4 mb-4">
                                <span class="label-text-alt text-error">{{ __($message) }}</span>
                            </div>
                        @else
                            <div class="mb-4 p-3 bg-base-200 rounded text-sm space-y-1">
                                <p class="font-semibold text-xs uppercase text-base-content opacity-70">Password Requirements:</p>
                                <ul class="list-disc list-inside space-y-1 text-xs text-base-content opacity-80">
                                    <li>{{ __('At least 8 characters') }}</li>
                                    <li>{{ __('Mixed case letters (uppercase & lowercase)') }}</li>
                                    <li>{{ __('At least one number') }}</li>
                                    <li>{{ __('At least one symbol (!@#$%^&*)') }}</li>
                                </ul>
                            </div>
                        @enderror

                        <!-- Remember Me -->
                        <div class="form-control mt-4">
                            <label class="label cursor-pointer justify-start">
                                <input type="checkbox"
                                       name="remember"
                                       class="checkbox">
                                <span class="label-text ml-2">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-control mt-8">
                            <button type="submit" class="btn btn-primary btn-sm w-full">
                                {{ __('Sign In') }}
                            </button>
                        </div>
                    </form>

                    <div class="divider">OR</div>
                    <p class="text-center text-sm">
                        {{ __('Don\'t have an account?') }}
                        <a href="{{ route('auth.sign-up') }}" class="link link-primary">{{ __('Register') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
