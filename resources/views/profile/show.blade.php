@props(['chirp'])

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
                                     alt="{{ auth()->user()->name }}'s avatar"
                                     class="rounded-full" />
                            </div>
                        </div>
                        <h1 class="text-xl font-bold">{{ auth()->user()->name }}</h1>
                        <span class="text-sm text-base-content/60">{{ auth()->user()->email }}</span>
                    </div>

                    {{-- Profile form --}}
                    <form method="POST">
                        @csrf
                        @method('PATCH')

                        {{-- Name --}}
                        <label class="floating-label mb-6">
                            <input type="text"
                                   name="name"
                                   placeholder="Ex: John Doe"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   class="input input-bordered @error('name') input-error @enderror"
                                   required
                                   autofocus>
                            <span>Full name</span>
                        </label>

                        @error('name')
                            <div class="label -mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        {{-- Email --}}
                        <label class="floating-label mb-6">
                            <input type="email"
                                   name="email"
                                   placeholder="Ex: mail@example.com"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   class="input input-bordered @error('email') input-error @enderror"
                                   required>
                            <span>Email</span>
                        </label>

                        @error('email')
                            <div class="label -mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <div class="divider">Change password</div>

                        {{-- Current password --}}
                        <label class="floating-label mb-6">
                            <input type="password"
                                   name="current_password"
                                   placeholder="••••••••"
                                   class="input input-bordered @error('current_password') input-error @enderror"
                                   minlength="8"
                                   maxlength="255"
                                   autocomplete="current-password">
                            <span>Current password</span>
                        </label>

                        @error('current_password')
                            <div class="label -mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        {{-- New password --}}
                        <label class="floating-label mb-6">
                            <input type="password"
                                   name="password"
                                   placeholder="••••••••"
                                   class="input input-bordered @error('password') input-error @enderror"
                                   minlength="8"
                                   maxlength="255"
                                   autocomplete="new-password">
                            <span>New password</span>
                        </label>

                        @error('password')
                            <div class="label -mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        {{-- Confirm new password --}}
                        <label class="floating-label mb-8">
                            <input type="password"
                                   name="password_confirmation"
                                   placeholder="••••••••"
                                   class="input input-bordered"
                                   minlength="8"
                                   maxlength="255"
                                   autocomplete="new-password">
                            <span>Confirm new password</span>
                        </label>

                        {{-- Submit --}}
                        <div class="form-control">
                            <button type="submit" class="btn btn-primary btn-sm w-full">
                                {{ __('Save changes') }}
                            </button>
                        </div>
                    </form>

                    <div class="divider"></div>

                    {{-- Danger zone --}}
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-base-content/60">{{ __('Want to leave?') }}</span>
                        <form method="POST" action="{{ route('auth.logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-sm text-error">
                                {{ __('Sign out') }}
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-layouts.main>
