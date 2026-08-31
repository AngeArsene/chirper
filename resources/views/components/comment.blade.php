@props(['comment'])

<div class="card bg-base-100">
    <div class="card-body">
        <div class="flex space-x-3">

            @if ($comment->user)
                <div class="avatar">
                    <div class="size-10 rounded-full">
                        <img src="https://avatars.laravel.cloud/{{ urlencode($comment->user->email) }}?vibe=ocean"
                            alt="{{ $comment->user->name }}'s avatar" class="rounded-full" />
                    </div>
                </div>
            @else
                <div class="avatar placeholder">
                    <div class="size-10 rounded-full">
                        <img src="https://avatars.laravel.cloud/f61123d5-0b27-434c-a4ae-c653c7fc9ed6?vibe=stealth"
                            alt="Anonymous User" class="rounded-full" />
                    </div>
                </div>
            @endif

            <div class="min-w-0 flex-1">
                <div class="flex justify-between w-full">
                    <div class="flex items-center gap-1">
                        <span
                            class="text-sm font-semibold">{{ $comment->user ? $comment->user->name : __('Anonymous') }}</span>
                        <span class="text-base-content/60">·</span>
                        @if ($comment->updated_at->gt($comment->created_at->addSeconds(5)))
                            <span class="text-sm text-base-content/60 italic">edited</span>
                            <span class="text-base-content/60"> · </span>
                        @endif
                        <span class="text-sm text-base-content/60">{{ __($comment->updated_at->diffForHumans()) }}</span>
                    </div>

                    <div class="flex gap-1">
                        @can('update', $comment)
                            <a href="{{ route('comments.edit', $comment) }}" class="btn btn-ghost btn-xs">
                                {{ __('Edit') }}
                            </a>
                        @endcan

                        @can('delete', $comment)
                            <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this comment?')"
                                    class="btn btn-ghost btn-xs text-error">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>

                <p class="mt-1">
                    {{ $comment->message }}
                </p>

                <x-engagement :comment="$comment" />
            </div>
        </div>
    </div>
</div>
