<x-layouts.main>
    <div class="hero min-h-[calc(100vh-16rem)]">
        <div class="hero-content flex-col w-full max-w-xl">

            <div class="card w-full bg-base-100">
                <div class="card-body">

                    {{-- Heading --}}
                    <div class="flex flex-col items-center gap-3 mb-6">
                        <h1 class="text-xl font-bold">Verify Your Identity</h1>
                        <p class="text-sm text-base-content/60">
                            Please enter your current password to continue.
                        </p>
                    </div>

                    {{-- Password form --}}
                    <form method="POST" action="{{ route('password.verify') }}">
                        @csrf
                        @method('POST')

                        <!-- Password -->
                        <x-password-field />

                        {{-- Submit --}}
                        <div class="form-control">
                            <button type="submit" class="btn btn-primary btn-sm w-full">
                                {{ __('Confirm Your Password') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-layouts.main>
