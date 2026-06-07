<x-layouts.error title="503 — Under Maintenance">
    <div class="card w-full max-w-xl bg-base-100">
        <div class="card-body text-center">
            <p class="text-7xl font-black">503</p>
            <h1 class="text-2xl font-bold mt-4">Under Maintenance</h1>
            <p class="mt-4 text-base-content/60">Chirper is temporarily down for maintenance. Please check back shortly.</p>
            <div class="mt-8">
                <a href="{{ route('chirps.index') }}" class="btn btn-primary btn-sm">Go back home</a>
            </div>
        </div>
    </div>
</x-layouts.error>
