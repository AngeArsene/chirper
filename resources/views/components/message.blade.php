<div class="card bg-base-100">
    <div class="card-body">
        <div class="flex space-x-3">

            @if ($message->user)
                <div class="avatar">
                    <div class="size-10 rounded-full">
                        <img src="https://avatars.laravel.cloud/{{ urlencode($message->user->email) }}?vibe=ocean"
                            alt="{{ $message->user->name }}'s avatar" class="rounded-full" />
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
                            class="text-sm font-semibold">{{ $message->user ? $message->user->name : __('Anonymous') }}</span>
                        <span class="text-base-content/60">·</span>
                        @if ($message->updated_at->gt($message->created_at->addSeconds(5)))
                            <span class="text-sm text-base-content/60 italic">edited</span>
                            <span class="text-base-content/60"> · </span>
                        @endif
                        <span class="text-sm text-base-content/60">{{ __($message->updated_at->diffForHumans()) }}</span>
                    </div>

                    <div class="flex gap-1">
                        @can('update', $message)
                            <a href="{{ route("$baseRouteName.edit", $message) }}" class="btn btn-ghost btn-xs">
                                {{ __('Edit') }}
                            </a>
                        @endcan

                        @can('delete', $message)
                            <form method="POST" action="{{ route("$baseRouteName.destroy", $message) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this {{ $for->value }}?')"
                                    class="btn btn-ghost btn-xs text-error">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>

                <p class="mt-1">
                    {{ $message->message }}
                </p>

                <x-engagement :message="$message" :baseRouteName="$baseRouteName" />
            </div>
        </div>
    </div>
</div>
