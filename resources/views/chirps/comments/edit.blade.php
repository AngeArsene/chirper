<x-layouts.main>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">{{ __('Edit Comment') }}</h1>

        <div class="card bg-base-100 mt-8">
            <div class="card-body">
                <form method="POST" action=" {{ route('chirps.comments.update', [$chirp, $comment]) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-control w-full">
                        <textarea
                            name="message"
                            class="textarea textarea-bordered w-full resize-none @error('message') textarea-error @enderror"
                            rows="4"
                            maxlength="255"
                            minlength="5"
                            required
                        >{{ old('message', $comment) }}</textarea>

                        <input type="hidden" name="old_message" value="{{ $comment->message }}">

                        @error('message')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="card-actions justify-between mt-4">
                        <a href="/" class="btn btn-ghost btn-sm">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            {{ __('Update Comment') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
