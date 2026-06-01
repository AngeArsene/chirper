<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Http\Requests\StoreChirpRequest;
use App\Http\Requests\UpdateChirpRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $chirps = Chirp::with('user')
            ->latest('updated_at')
            ->take(10)
            ->get();

        return $this->resolve_view(compact('chirps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChirpRequest $request): RedirectResponse
    {
        Chirp::create($request->validated());

        return redirect()
            ->route('chirps.index')
            ->with('success', __('Your chirp has been posted!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        return $this->resolve_view(compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChirpRequest $request, Chirp $chirp): RedirectResponse
    {
        $chirp->update($request->validated());

        return redirect()
            ->route('chirps.index')
            ->with('success', __('Your chirp has been updated!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        $chirp->delete();

        return redirect()
            ->route('chirps.index')
            ->with('success', __('Your chirp has been deleted!'));
    }
}
