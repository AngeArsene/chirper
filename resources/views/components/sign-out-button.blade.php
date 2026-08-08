<div class="divider"></div>

{{-- Danger zone --}}
<div class="flex items-center justify-between">
    <a href="{{ route('profile.password.edit') }}" class="btn btn-primary btn-sm text-error">
        {{ __('Edit Password') }}
    </a>
    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Are you sure you want to delete your profile?')"
            class="btn btn-ghost btn-sm text-error">
            {{ __('Sign out') }}
        </button>
    </form>
</div>
