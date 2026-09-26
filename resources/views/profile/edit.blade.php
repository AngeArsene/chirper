<x-layouts.profile :user="auth()->user()" :editProfileImages="true">
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
</x-layouts.profile>
