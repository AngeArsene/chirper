<div class="card bg-base-100 shadow mt-8">
    <div class="card-body">
        <form method="POST" action="{{ route('chirps.store') }}">
            @csrf
            <div class="form-control w-full">
                <textarea name="message" placeholder="What's on your mind?"
                    class="textarea textarea-bordered w-full resize-none @error('message') textarea-error @enderror" rows="4"
                    maxLength="255" minLength="5" required>{{ old('message') }}</textarea>

                @error('message')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ __($message) }}</span>
                    </div>
                @enderror

                <input type="hidden" name="idempotency_key" value="{{ old('idempotency_key', (string) Str::uuid()) }}">

                @error('idempotency_key')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ __($message) }}</span>
                    </div>
                @enderror
            </div>

            <div class="mt-4 flex items-center justify-end">
                <button type="submit" class="btn btn-primary btn-sm">
                    Chirp
                </button>
            </div>
        </form>
    </div>
</div>
