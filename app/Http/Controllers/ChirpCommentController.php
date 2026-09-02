<?php

namespace App\Http\Controllers;

use App\Enums\EngagementType;
use App\Http\Requests\StoreChirpCommentRequest;
use App\Http\Requests\UpdateChirpCommentRequest;
use App\Models\Chirp;
use App\Models\ChirpComment;
use App\Models\User;
use App\Pipelines\WithChirpAuthor;
use App\Pipelines\WithEngagementCount;
use App\Pipelines\WithUserEngagementFlag;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\View\View;

class ChirpCommentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAll', ChirpComment::class);

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
    public function store(StoreChirpCommentRequest $request, Chirp $chirp, #[CurrentUser] User $user): RedirectResponse
    {
        $chirp->comments()->create([
            ...$request->validated(),
            'user_id' => $user->id,
        ]);

        return back()->with('success', 'Comment added successfully.');
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
