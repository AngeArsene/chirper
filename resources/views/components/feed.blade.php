@props(['chirps'])

@forelse ($chirps as $chirp)
    <x-chirp :chirp="$chirp" />
@empty
    <x-empty-state message="No bookmarks yet — tap the bookmark icon on any chirp to save it here.!" />
@endforelse

@if ($chirps instanceof \Illuminate\Pagination\AbstractPaginator && $chirps->hasPages())
    <div class="hero">
        <div class="hero-content text-center">
            <div>
                <p class="mt-4 text-base-content/60">{{ $chirps->links() }}</p>
            </div>
        </div>
    </div>
@endif
