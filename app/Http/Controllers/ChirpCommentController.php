<?php

namespace App\Http\Controllers;

use App\Enums\EngagementType;
use App\Http\Requests\StoreChirpCommentRequest;
use App\Http\Requests\UpdateChirpCommentRequest;
use App\Models\Chirp;
use App\Models\ChirpComment;
use App\Pipelines\WithChirpAuthor;
use App\Pipelines\WithEngagementCount;
use App\Pipelines\WithUserEngagementFlag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;

class ChirpCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $chirp = Pipeline::send(Chirp::where('id', $request->route('chirp')))
            ->through([
                new WithChirpAuthor,
                new WithEngagementCount(EngagementType::Like, EngagementType::Comment),
                new WithUserEngagementFlag(EngagementType::Like, EngagementType::Bookmark),
            ])
            ->thenReturn()
            ->firstOrFail();

        $comments = ChirpComment::with('user:id,name,email')
            ->whereBelongsTo($chirp)
            ->latest()
            ->paginate(10);

        return $this->resolve_view(compact('chirp', 'comments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChirpCommentRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChirpComment $chirpComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChirpCommentRequest $request, ChirpComment $chirpComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChirpComment $chirpComment)
    {
        //
    }
}
