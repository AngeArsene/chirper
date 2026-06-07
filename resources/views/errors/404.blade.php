<x-layouts.error title="404 — Not Found">
    <div class="card w-full max-w-xl bg-base-100">
        <div class="card-body text-center">
            <p class="text-7xl font-black">404</p>
            <h1 class="text-2xl font-bold mt-4">Not Found</h1>
            <p class="mt-4 text-base-content/60">The page you're looking for doesn't exist or has been moved.</p>
            <div class="mt-8">
                <a href="{{ route('chirps.index') }}" class="btn btn-primary btn-sm">Go back home</a>
            </div>
        </div>
    </div>
</x-layouts.error>
