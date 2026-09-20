<x-layouts.main>
    <div class="hero min-h-[calc(100vh-16rem)]">
        <div class="hero-content flex-col w-full max-w-xl">

            <div class="card w-full bg-base-100 shadow-xl overflow-hidden">

                {{-- Cover image --}}
                <figure class="h-40 w-full">
                    <img src="https://images.unsplash.com/photo-1493246507139-91e8fad9978e?auto=format&fit=crop&w=1200&h=400&q=80"
                        alt="{{ __(auth()->user()->name . "'s cover image") }}" class="h-full w-full object-cover">
                </figure>

                <div class="card-body pt-0">

                    {{-- Avatar + heading --}}
                    <div class="flex flex-col items-center gap-3 mb-6">
                        <div class="avatar -mt-12 rounded-full ring-4 ring-base-100 bg-base-100">
                            <x-profile-avatar :user="auth()->user()" />
                        </div>
                        <h1 class="text-xl font-bold">{{ auth()->user()->name }}</h1>
                        <span class="text-sm text-base-content/60">{{ auth()->user()->email }}</span>
                    </div>

                    <div>
                        {{-- Name --}}
                        <label class="floating-label mb-6">
                            <input type="text" name="name" placeholder="Ex: John Doe"
                                value="{{ auth()->user()->name }}" class="input input-bordered" disabled autofocus>
                            <span>{{ __('Full name') }}</span>
                        </label>

                        {{-- Email --}}
                        <label class="floating-label mb-6">
                            <input type="email" name="email" placeholder="Ex: mail@example.com"
                                value="{{ auth()->user()->email }}" class="input input-bordered" disabled required>
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
