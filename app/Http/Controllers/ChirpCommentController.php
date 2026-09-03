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
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Handles listing, creating, editing, updating, and deleting chirp comments.
 */
class ChirpCommentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a paginated list of comments for a chirp.
     *
     * @param  Request  $request  The request containing the chirp route parameter.
     * @return View The rendered comments index view.
     *
     * @throws AuthorizationException If viewing all comments is not permitted.
     * @throws ModelNotFoundException If the requested chirp does not exist.
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

        $comments = Pipeline::send(ChirpComment::query())
            ->through([
                new WithChirpAuthor,
                new WithEngagementCount(EngagementType::Like),
                new WithUserEngagementFlag(EngagementType::Like),
            ])
            ->thenReturn()
            ->whereBelongsTo($chirp)
            ->latest()
            ->paginate(10);

        return $this->resolve_view(compact('chirp', 'comments'));
    }

    /**
     * Persist a validated comment for the authenticated user.
     *
     * @param  StoreChirpCommentRequest  $request  The request containing the validated comment data.
     * @param  Chirp  $chirp  The chirp receiving the comment, resolved from the route.
     * @param  User  $user  The authenticated user creating the comment.
     * @return RedirectResponse A redirect back to the previous page with a success message.
     *
     * @throws ValidationException If the comment data fails validation.
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
     * Render the edit form for an authorized comment.
     *
     * @param  Chirp  $chirp  The chirp associated with the comment, resolved from the route.
     * @param  ChirpComment  $comment  The comment to edit, resolved from the route.
     * @return View The rendered comment edit view.
     *
     * @throws AuthorizationException If the current user cannot update the comment.
     */
    public function edit(Chirp $chirp, ChirpComment $comment): View
    {
        $this->authorize('update', $comment);

        return $this->resolve_view(compact('chirp', 'comment'));
    }

    /**
     * Apply validated changes to an existing comment.
     *
     * @param  UpdateChirpCommentRequest  $request  The request containing the validated replacement content.
     * @param  Chirp  $chirp  The chirp associated with the comment, resolved from the route.
     * @param  ChirpComment  $comment  The comment to update, resolved from the route.
     * @return RedirectResponse A redirect to the chirp comments index with a success message.
     *
     * @throws ValidationException If the replacement comment data fails validation.
     */
    public function update(UpdateChirpCommentRequest $request, Chirp $chirp, ChirpComment $comment): RedirectResponse
    {
        $comment->update($request->validated());

        return redirect()->route('chirps.comments.index', $chirp)->with('success', 'Comment updated successfully.');
    }

    /**
     * Delete an authorized comment.
     *
     * @param  Chirp  $chirp  The chirp associated with the comment, resolved from the route.
     * @param  ChirpComment  $comment  The comment to delete, resolved from the route.
     * @return RedirectResponse A redirect back to the previous page with a success message.
     *
     * @throws AuthorizationException If the current user cannot delete the comment.
     */
    public function destroy(Chirp $chirp, ChirpComment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
