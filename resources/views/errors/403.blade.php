<x-layouts.error title="403 — Forbidden">
    <div class="card w-full max-w-xl bg-base-100">
        <div class="card-body text-center">
            <p class="text-7xl font-black">403</p>
            <h1 class="text-2xl font-bold mt-4">Forbidden</h1>
            <p class="mt-4 text-base-content/60">You don't have permission to access this page.</p>
            <div class="mt-8">
                <a href="{{ route('chirps.index') }}" class="btn btn-primary btn-sm">Go back home</a>
            </div>
        </div>
    </div>
</x-layouts.error>
