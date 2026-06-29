@props(['chirps'])

 @forelse ($chirps as $chirp)
     <x-chirp :chirp="$chirp" />
 @empty
     <x-empty-state message="No chirps yet. Be the first to post one!" />
 @endforelse

 @if ($chirps instanceof \Illuminate\Pagination\LengthAwarePaginator && $chirps->hasPages())
     <div class="hero">
         <div class="hero-content text-center">
             <div>
                 <p class="mt-4 text-base-content/60">{{ $chirps->links() }}</p>
             </div>
         </div>
     </div>
 @endif
