@props(['chirps'])

<x-layouts.main>
     <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">Latest Chirps</h1>

        <x-chirp-form />

        <div class="space-y-4 mt-8">

            <x-feed :chirps=$chirps />

        </div>
    </div>
</x-layouts.main>
