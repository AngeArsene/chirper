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

                    <div>
                        {{-- Name --}}
                        <label class="floating-label mb-6">
                            <input type="text" name="name" placeholder="Ex: John Doe"
                                value="{{ auth()->user()->name }}" class="input input-bordered" disabled
                                autofocus>
                            <span>{{ __('Full name') }}</span>
                        </label>

                        {{-- Email --}}
                        <label class="floating-label mb-6">
                            <input type="email" name="email" placeholder="Ex: mail@example.com"
                                value="{{ auth()->user()->email }}" class="input input-bordered" disabled
                                required>
                            <span>{{ __('Email') }}</span>
                        </label>

                        <div class="divider">{{ __('Edit profile ?') }}</div>

                        <div class="form-control">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm w-full">
                                {{ __('Edit my profile') }}
                            </a>
                        </div>
                    </div>

                    <x-sign-out-button />

                </div>
            </div>

        </div>
    </div>
</x-layouts.main>
