<x-layouts.main>
    <div class="hero min-h-[calc(100vh-16rem)]">
        <div class="hero-content flex-col w-full max-w-xl">

            <div class="card w-full bg-base-100 shadow-xl overflow-hidden">

                {{-- Cover image --}}
                <div class="relative">
                    <figure class="h-40 w-full">
                        <img src="https://images.unsplash.com/photo-1493246507139-91e8fad9978e?auto=format&fit=crop&w=1200&h=400&q=80"
                            alt="{{ __(auth()->user()->name . "'s cover image") }}" class="h-full w-full object-cover">
                    </figure>

                    <form method="POST" action="" enctype="multipart/form-data" class="absolute top-3 right-3 z-10">
                        @csrf
                        @method('PUT')
                        <label for="cover" title="{{ __('Change cover image') }}"
                            class="btn btn-sm gap-2 rounded-full border-0 bg-black/40 text-white shadow-lg backdrop-blur-md transition hover:bg-black/60 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                                <circle cx="12" cy="13" r="3" />
                            </svg>
                            <span class="hidden sm:inline">{{ __('Edit cover') }}</span>
                        </label>
                        <input type="file" id="cover" name="cover" accept="image/png,image/jpeg,image/webp"
                            class="hidden" onchange="this.form.requestSubmit()">
                    </form>
                </div>

                <div class="card-body pt-0">

                    {{-- Avatar + heading --}}
                    <div class="flex flex-col items-center gap-3 mb-6">
                        <div class="avatar relative -mt-12 rounded-full ring-4 ring-base-100 bg-base-100">
                            <x-profile-avatar :user="auth()->user()" />

                            <form method="POST" action="{{ route('profile.avatar.update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <label for="avatar"
                                    class="absolute bottom-0 right-0 btn btn-circle btn-xs btn-primary cursor-pointer border-2 border-base-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </label>
                                <input type="file" id="avatar" name="avatar"
                                    accept="image/png,image/jpeg,image/webp" class="hidden"
                                    onchange="this.form.requestSubmit()">
                            </form>
                        </div>

                        @error('avatar')
                            <div role="alert" class="alert alert-error alert-soft w-fit text-sm py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror

                        <h1 class="text-xl font-bold">{{ auth()->user()->name }}</h1>
                        <span class="text-sm text-base-content/60">{{ auth()->user()->email }}</span>
                    </div>

                    {{-- Profile form --}}
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        {{-- Name --}}
                        <label class="floating-label mb-6">
                            <input type="text" name="name" placeholder="Ex: John Doe"
                                value="{{ old('name', auth()->user()->name) }}"
                                class="input input-bordered @error('name') input-error @enderror" required
                                maxlength="255" minlength="4" autofocus>
                            <span>Full name</span>
                        </label>

                        @error('name')
                            <div class="label -mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        {{-- Email --}}
                        <label class="floating-label mb-6">
                            <input type="email" name="email" placeholder="Ex: mail@example.com"
                                value="{{ old('email', auth()->user()->email) }}"
                                class="input input-bordered @error('email') input-error @enderror" required>
                            <span>Email</span>
                        </label>

                        @error('email')
                            <div class="label -mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        {{-- Submit --}}
                        <div class="form-control">
                            <button type="submit" class="btn btn-primary btn-sm w-full">
                                {{ __('Save changes') }}
                            </button>
                        </div>
                    </form>

                    <x-sign-out-button />

                </div>
            </div>

        </div>
    </div>
</x-layouts.main>
