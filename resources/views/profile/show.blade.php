<x-layouts.profile :user="auth()->user()">
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

        <div class="form-control">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm w-full">
                {{ __('Edit my profile') }}
            </a>
        </div>
    </div>

    <x-sign-out-button />
</x-layouts.profile>
