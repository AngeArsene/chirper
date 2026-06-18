<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChirpRequest;
use App\Http\Requests\UpdateChirpRequest;
use App\Models\Chirp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChirpController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $chirps = Chirp::with('user:id,name,email')
            ->latest('updated_at')
            ->paginate(10);

        return $this->resolve_view(compact('chirps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChirpRequest $request): RedirectResponse
    {
        $this->authorize('create', Chirp::class);

        Auth::user()->chirps()->create($request->validated());

        return to_route('chirps.index')
            ->with('success', __('Your chirp has been posted!'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        $this->authorize('update', $chirp);

        return $this->resolve_view(compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChirpRequest $request, Chirp $chirp): RedirectResponse
    {
        $this->authorize('update', $chirp);

        $chirp->update($request->validated());

        return to_route('chirps.index')
            ->with('success', __('Your chirp has been updated!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return to_route('chirps.index')
            ->with('success', __('Your chirp has been deleted!'));
    }
}
