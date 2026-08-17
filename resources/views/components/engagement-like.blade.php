@props(['chirp'])

@if ($chirp->liked_by_current_user)
    <form method="POST" action="{{ route('chirps.like', $chirp) }}">
        @csrf
        @method('DELETE')

        <button type="submit"
            class="flex items-center gap-1.5 rounded-full px-3 py-1.5 transition-colors hover:bg-error/10 {{ $chirp->liked_by_current_user ? 'text-error' : 'text-base-content/60 hover:text-error' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24"
                fill="{{ $chirp->liked_by_current_user ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.75"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 14c1.5-1.5 3-3.34 3-5.5A5.5 5.5 0 0 0 12 5a5.5 5.5 0 0 0-10 3.5c0 2.16 1.5 4 3 5.5l7 7z" />
            </svg>
            <span class="text-xs font-medium tabular-nums">{{ $chirp->likes_count }}</span>
        </button>
    </form>
@else
    <form method="POST" action="{{ route('chirps.like', $chirp) }}">
        @csrf
        @method('POST')

        <button type="submit"
            class="flex items-center gap-1.5 rounded-full px-3 py-1.5 transition-colors hover:bg-error/10 {{ $chirp->liked_by_current_user ? 'text-error' : 'text-base-content/60 hover:text-error' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24"
                fill="{{ $chirp->liked_by_current_user ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.75"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 14c1.5-1.5 3-3.34 3-5.5A5.5 5.5 0 0 0 12 5a5.5 5.5 0 0 0-10 3.5c0 2.16 1.5 4 3 5.5l7 7z" />
            </svg>
            <span class="text-xs font-medium tabular-nums">{{ $chirp->likes_count }}</span>
        </button>
    </form>
@endif
