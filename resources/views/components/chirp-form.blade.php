<!-- Chirp Form -->
<div class="card bg-base-100 shadow mt-8">
    <div class="card-body">
        <form method="POST" action="{{ route('chirps.store') }}">
            @csrf
            <div class="form-control w-full">
                <textarea name="message" placeholder="What's on your mind?" class="textarea textarea-bordered w-full resize-none"
                    rows="4" maxlength="255" required></textarea>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <button type="submit" class="btn btn-primary btn-sm">
                    Chirp
                </button>
            </div>
        </form>
    </div>
</div>
