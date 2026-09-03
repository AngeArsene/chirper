@props(['chirp', 'comments'])

<x-layouts.main>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">{{ __('Comments for : ') }}</h1>

        <div class="card bg-base-100 shadow mt-8">
            <x-message
                :message="$chirp"
                baseRouteName="chirps"
            />
        </div>

        <x-message-form
            :for="\App\Enums\MessageableType::Comment"
            baseRouteName="chirps.comments"
            :parent="$chirp"
        />

        <div class="divider">{{ __('Comments Feed : ') }}</div>

        <div class="space-y-4 mt-8">

            <x-feed
                :messages="$comments"
                baseRouteName="chirps.comments"
                emptyStateMessage="No comments yet — be the first to share what you think"
                :parent="$chirp"
            />

        </div>
    </div>
</x-layouts.main>
