@props(['comments'])

@forelse ($comments as $comment)
    <x-comment :chirp="$comment" />
@empty
    <x-empty-state message="No comments yet — be the first to reply." />
@endforelse

@if ($chirps instanceof \Illuminate\Pagination\AbstractPaginator && $chirps->hasPages())
    <div class="hero">
        <div class="hero-content text-center">
            <div>
                <p class="mt-4 text-base-content/60">{{ $comments->links() }}</p>
            </div>
        </div>
    </div>
@endif
