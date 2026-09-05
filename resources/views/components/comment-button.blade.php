@props(['message'])

<a href="{{ route('chirps.comments.index', $message) }}"
    class="flex items-center gap-1.5 rounded-full px-3 py-1.5 text-base-content/60 transition-colors hover:bg-primary/10 hover:text-primary">
    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
        <path
            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
    </svg>
    <span class="text-xs font-medium tabular-nums">{{ $message->comments_count }}</span>
</a>
