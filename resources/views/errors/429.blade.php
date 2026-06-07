<x-layouts.error title="429 — Too Many Requests">
    <div class="card w-full max-w-xl bg-base-100">
        <div class="card-body text-center">
            <p class="text-7xl font-black">429</p>
            <h1 class="text-2xl font-bold mt-4">Too Many Requests</h1>
            <p class="mt-4 text-base-content/60">You've made too many requests in a short period. Please wait a moment and try again.</p>
            <div class="mt-8">
                <a href="{{ route('chirps.index') }}" class="btn btn-primary btn-sm">Go back home</a>
            </div>
        </div>
    </div>
</x-layouts.error>
