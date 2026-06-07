<x-layouts.error title="401 — Unauthorized">
    <div class="card w-full max-w-xl bg-base-100">
        <div class="card-body text-center">
            <p class="text-7xl font-black">401</p>
            <h1 class="text-2xl font-bold mt-4">Unauthorized</h1>
            <p class="mt-4 text-base-content/60">You need to be logged in to access this page.</p>
            <div class="mt-8">
                <a href="{{ route('auth.sign-in') }}" class="btn btn-primary btn-sm">Sign in</a>
            </div>
        </div>
    </div>
</x-layouts.error>
