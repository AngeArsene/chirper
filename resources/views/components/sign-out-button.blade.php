<div class="divider"></div>

{{-- Danger zone --}}
<div class="flex items-center justify-between">
    <span class="text-sm text-base-content/60">{{ __('Want to leave?') }}</span>
    <form method="POST" action="{{ route('profile.destroy', auth()->user()) }}">
        @csrf
        <button type="submit"
            onclick="return confirm('Are you sure you want to delete your profile?')"
            class="btn btn-ghost btn-sm text-error">
            {{ __('Sign out') }}
        </button>
    </form>
</div>
