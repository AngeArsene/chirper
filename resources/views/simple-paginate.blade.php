@if ($paginator->hasPages())
    <div class="flex items-center justify-center gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button disabled class="btn btn-ghost btn-sm btn-disabled">
                « {{ __('Previous') }}
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-ghost btn-sm">
                « {{ __('Previous') }}
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-ghost btn-sm">
                {{ __('Next') }} »
            </a>
        @else
            <button disabled class="btn btn-ghost btn-sm btn-disabled">
                {{ __('Next') }} »
            </button>
        @endif
    </div>
@endif
