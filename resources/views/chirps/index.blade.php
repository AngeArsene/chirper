@props(['chirps'])

<x-layouts.main>
    <div class="max-w-2xl mx-auto">
        @forelse ($chirps as $chirp)
            <div class="card bg-base-100 shadow mt-8">
                <div class="card-body">
                    <div>
                        <div class="font-semibold">{{ $chirp->user ? $chirp->user->name : 'Unknown User' }}</div>
                        <div class="mt-1">{{ $chirp->message }}</div>
                        <div class="text-sm text-gray-500 mt-2">{{ $chirp->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center mt-8 text-gray-500">No chirps yet. Be the first to chirp!</div>
        @endforelse
    </div>
</x-layouts.main>
