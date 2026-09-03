@props(['chirps'])

<x-layouts.main>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">{{ __('Latest Chirps') }}</h1>

        <x-message-form
            :for="\App\Enums\MessageableType::Chirp"
            baseRouteName="chirps"
        />

        <div class="space-y-4 mt-8">

            <x-feed
                :messages="$chirps"
                baseRouteName="chirps"
                emptyStateMessage="No chirps yet — be the first to share something."
            />

        </div>
    </div>
</x-layouts.main>
