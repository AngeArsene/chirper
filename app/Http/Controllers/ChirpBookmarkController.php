<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChirpBookmarkRequest;
use App\Models\Chirp;
use App\Models\ChirpBookmark;
use Illuminate\Support\Facades\Auth;

class ChirpBookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chirps = Chirp::whereHas('bookmarks', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->with('user:id,name,email')
            ->withCount('likes')
            ->withExists([
                'likes as liked_by_current_user' => fn($query) => $query->where('user_id', Auth::id()),
            ])
            ->withExists([
                'bookmarks as bookmarked_by_current_user' => fn($query) => $query->where('user_id', Auth::id()),
            ])
            ->latest('created_at')
            ->paginate(10);

        return $this->resolve_view(compact('chirps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChirpBookmarkRequest $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChirpBookmark $chirpBookmark)
    {
        //
    }
}
