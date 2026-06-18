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

        {{-- Pagination Elements --}}
        <div class="flex items-center gap-1">
            @php
                $current = $paginator->currentPage();
                $last    = $paginator->lastPage();
                $window  = 2;
                $start   = max(1, $current - $window);
                $end     = min($last, $current + $window);
            @endphp

            {{-- First Page Link (if not in window) --}}
            @if ($start > 1)
                <a href="{{ $paginator->url(1) }}" class="btn btn-ghost btn-sm">1</a>

                @if ($start > 2)
                    <span class="px-2 text-base-content/60">...</span>
                @endif
            @endif

            {{-- Numbered Page Links (window) --}}
            @foreach (range($start, $end) as $page)
                @if ($page == $current)
                    <button disabled class="btn btn-primary btn-sm">
                        {{ $page }}
                    </button>
                @else
                    <a href="{{ $paginator->url($page) }}" class="btn btn-ghost btn-sm">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Last Page Link (if not in window) --}}
            @if ($end < $last)
                @if ($end < $last - 1)
                    <span class="px-2 text-base-content/60">...</span>
                @endif

                <a href="{{ $paginator->url($last) }}" class="btn btn-ghost btn-sm">{{ $last }}</a>
            @endif
        </div>

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
