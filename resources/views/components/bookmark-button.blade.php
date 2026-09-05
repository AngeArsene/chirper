<form method="POST" action="{{ route('chirps.bookmark', $message) }}" class="ml-auto">
    @csrf
    @method($method)

    <button type="submit"
        class="flex items-center gap-1.5 rounded-full px-3 py-1.5 transition-colors hover:bg-primary/10 {{ $isBookmarked ? 'text-primary' : 'text-base-content/60 hover:text-primary' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24"
            fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.75"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 4a2 2 0 0 0-2 2v14l8-4 8 4V6a2 2 0 0 0-2-2H6z" />
        </svg>
    </button>
</form>
