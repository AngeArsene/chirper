<?php

namespace App\Http\Controllers;

use App\Enums\EngagementType;
use App\Http\Requests\StoreChirpRequest;
use App\Http\Requests\UpdateChirpRequest;
use App\Models\Chirp;
use App\Models\User;
use App\Pipelines\WithChirpAuthor;
use App\Pipelines\WithEngagementCount;
use App\Pipelines\WithUserEngagementFlag;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Handles listing, creating, editing, updating, and deleting chirps.
 */
class ChirpController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display the paginated chirp feed with author and engagement data.
     *
     * @return View The rendered chirp index view.
     *
     * @throws AuthorizationException If viewing the chirp feed is not permitted.
     */
    public function index(): View
    {
        $this->authorize('viewAll', Chirp::class);

        $chirps = Pipeline::send(Chirp::query())
            ->through([
                new WithChirpAuthor,
                new WithEngagementCount(EngagementType::Like, EngagementType::Comment),
                ...(Auth::check() ? [
                    new WithUserEngagementFlag(EngagementType::Like, EngagementType::Bookmark),
                ] : []),
            ])
            ->thenReturn()
            ->latest('updated_at')
            ->paginate(10);

        return $this->resolve_view(compact('chirps'));
    }

    /**
     * Persist a validated chirp for the authenticated user.
     *
     * @param  StoreChirpRequest  $request  The request containing the validated chirp data.
     * @param  User  $user  The authenticated user who owns the new chirp.
     * @return RedirectResponse A redirect to the chirp feed with a success message.
     *
     * @throws AuthorizationException If the user cannot create a chirp.
     * @throws ValidationException If the chirp data fails validation.
     *
     * @example A valid request includes a message and a unique UUID idempotency key.
     */
    public function store(StoreChirpRequest $request, #[CurrentUser] User $user): RedirectResponse
    {
        $user->chirps()->create($request->validated());

        return to_route('chirps.index')->with('success', 'Your chirp has been posted!');
    }

    /**
     * Render the edit form for a chirp owned by the authorized user.
     *
     * @param  Chirp  $chirp  The chirp to edit, resolved from the route.
     * @return View The rendered chirp edit view.
     *
     * @throws AuthorizationException If the current user cannot update the chirp.
     */
    public function edit(Chirp $chirp): View
    {
        $this->authorize('update', $chirp);

        return $this->resolve_view(compact('chirp'));
    }

    /**
     * Apply validated changes to an existing chirp.
     *
     * @param  UpdateChirpRequest  $request  The request containing the validated replacement message.
     * @param  Chirp  $chirp  The chirp to update, resolved from the route.
     * @return RedirectResponse A redirect to the chirp feed with a success message.
     *
     * @throws AuthorizationException If the current user cannot update the chirp.
     * @throws ValidationException If the replacement message fails validation.
     */
    public function update(UpdateChirpRequest $request, Chirp $chirp): RedirectResponse
    {
        $chirp->update($request->validated());

        return to_route('chirps.index')->with('success', 'Your chirp has been updated!');
    }

    /**
     * Delete a chirp owned by the authorized user.
     *
     * @param  Chirp  $chirp  The chirp to delete, resolved from the route.
     * @return RedirectResponse A redirect to the chirp feed with a success message.
     *
     * @throws AuthorizationException If the current user cannot delete the chirp.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return to_route('chirps.index')->with('success', 'Your chirp has been deleted!');
    }
}
