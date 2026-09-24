<x-layouts.main>
    <div class="hero min-h-[calc(100vh-16rem)]">
        <div class="hero-content flex-col w-full max-w-xl">

            <div class="card w-full bg-base-100 shadow-xl overflow-hidden">

                @if ($edit)
                    {{-- Cover image --}}
                    <div class="relative">
                        <x-profile-cover :user="$user" />

                        <form method="POST" action="{{ route('profile.cover.update') }}" enctype="multipart/form-data" class="absolute top-3 right-3 z-10">
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
                @else
                    {{-- Cover image --}}
                    <x-profile-cover :user="$user" />
                @endif

                <div class="card-body pt-0">

                    @if ($edit)
                        {{-- Avatar + heading --}}
                        <div class="flex flex-col items-center gap-3 mb-6">
                            <div class="avatar relative -mt-12 rounded-full ring-4 ring-base-100 bg-base-100">
                                <x-profile-avatar :user="$user" />

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

                            <h1 class="text-xl font-bold">{{ $user->name }}</h1>
                            <span class="text-sm text-base-content/60">{{ $user->email }}</span>
                        </div>
                    @else
                        {{-- Avatar + heading --}}
                        <div class="flex flex-col items-center gap-3 mb-6">
                            <div class="avatar -mt-12 rounded-full ring-4 ring-base-100 bg-base-100">
                                <x-profile-avatar :user="$user" />
                            </div>
                            <h1 class="text-xl font-bold">{{ $user->name }}</h1>
                            <span class="text-sm text-base-content/60">{{ $user->email }}</span>
                        </div>
                    @endif

                    {{ $slot }}

                </div>
            </div>

        </div>
    </div>
</x-layouts.main>
