@props(['chirp', 'comments'])

<x-layouts.main>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">{{ __('Comments') }}</h1>

        <x-message
            :message="$chirp"
            :for="\App\Enums\MessageableType::Chirp"
            base_route_name="chirps"
        />

        <div class="space-y-4 mt-8">

            <x-feed
                :messages="$comments"
                :for="\App\Enums\MessageableType::Comment"
                baseRouteName="chirps.comments"
                emptyStateMessage="No comments yet — be the first to share what you think"
            />

        </div>
    </div>
</x-layouts.main>
