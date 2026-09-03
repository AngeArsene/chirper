@forelse ($messages as $massage)
    <x-message
        :message="$massage"
        :baseRouteName="$baseRouteName"
        :parent="$parent"
    />
@empty
    <x-empty-state :message="$emptyStateMessage" />
@endforelse

@if ($messages instanceof \Illuminate\Pagination\AbstractPaginator && $messages->hasPages())
    <div class="hero">
        <div class="hero-content text-center">
            <div>
                <p class="mt-4 text-base-content/60">{{ $messages->links() }}</p>
            </div>
        </div>
    </div>
@endif
