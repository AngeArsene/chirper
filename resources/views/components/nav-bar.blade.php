<nav class="navbar bg-base-100">
    <div class="navbar-start">
        <a href="/" class="btn btn-ghost text-xl">🐦 Chirper</a>
    </div>
    <div class="navbar-end gap-2">
        <a href="{{ route('auth.sign-in') }}" class="btn btn-ghost btn-sm">Sign In</a>
        <a href="{{ route('auth.sign-up') }}" class="btn btn-primary btn-sm">Sign Up</a>
    </div>
</nav>
