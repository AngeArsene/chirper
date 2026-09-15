<x-layouts.main>
    <div class="hero min-h-[calc(100vh-16rem)]">
        <div class="hero-content flex-col w-full max-w-xl">

            <div class="card w-full bg-base-100">
                <div class="card-body">

                    {{-- Avatar + heading --}}
                    <div class="flex flex-col items-center gap-3 mb-6">
                        <div class="avatar relative">
                            <x-profile-avatar :user="auth()->user()" />

                            {{-- Pencil edit button --}}
                            <form method="POST" action="{{ route('profile.avatar.update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <label for="avatar-upload"
                                    class="absolute bottom-0 right-0 btn btn-circle btn-xs btn-primary cursor-pointer border-2 border-base-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </label>
                                <input type="file" id="avatar-upload" name="avatar"
                                    accept="image/png,image/jpeg,image/webp" class="hidden"
                                    onchange="this.form.requestSubmit()">
                            </form>
                        </div>
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
