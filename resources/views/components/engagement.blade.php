@props(['message', 'baseRouteName'])

<div class="mt-3 -ml-2 flex items-center gap-1">
    @isset($message->comments_count)
        {{-- Reply --}}
        <x-comment-button :message="$message" />
    @endisset

    @isset($message->likes_count)
        {{-- Like --}}
        <x-like-button :message="$message" :baseRouteName="$baseRouteName" />
    @endisset

    @isset($message->bookmarked_by_current_user)
        {{-- Bookmark --}}
        <x-bookmark-button :message="$message" />
    @endisset
</div>
