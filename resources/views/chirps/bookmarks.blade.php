@props(['chirps'])

<x-layouts.main>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">{{ __('Bookmarks') }}</h1>

        <div class="space-y-4 mt-8">

            <x-feed
                :messages="$chirps"
                :for="\App\Enums\MessageableType::Chirp"
                baseRouteName="chirps"
                emptyStateMessage="No bookmarks yet — tap the bookmark icon on any chirp to save it here."
            />

        </div>
    </div>
</x-layouts.main>
