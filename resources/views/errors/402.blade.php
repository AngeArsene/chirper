<x-layouts.error title="402 — Payment Required">
    <div class="card w-full max-w-xl bg-base-100">
        <div class="card-body text-center">
            <p class="text-7xl font-black">402</p>
            <h1 class="text-2xl font-bold mt-4">Payment Required</h1>
            <p class="mt-4 text-base-content/60">Access to this page requires an active subscription.</p>
            <div class="mt-8">
                <a href="{{ route('chirps.index') }}" class="btn btn-primary btn-sm">Go back home</a>
            </div>
        </div>
    </div>
</x-layouts.error>
