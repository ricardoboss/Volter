<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\DeleteException;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        /* @var User $user */
        //$user = auth()->user();

        // TODO: only return users visible to the authenticated user
        return UserResource::collection(User::all()->paginate(20));
    }

    /**
     * Create a new user.
     *
     * @throws AuthorizationException if the currently authenticated user cannot create a new user
     */
    public function create(): void
    {
        $this->authorize('create', User::class);

        // TODO: create user from request data
    }

    /**
     * Returns the specified user.
     *
     * @throws AuthorizationException if the currently authenticated user cannot view the specified user
     */
    public function view(User $user): UserResource
    {
        $this->authorize('view', $user);

        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws AuthorizationException if the currently authenticated user cannot update the specified user
     */
    public function update(User $user): void
    {
        $this->authorize('update', $user);

        // TODO: modify user
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException if the currently authenticated user cannot delete the specified user
     * @throws DeleteException if deleting the user fails
     */
    public function delete(User $user): bool
    {
        $this->authorize('delete', $user);

        try {
            return $user->delete();
        } catch (Exception $e) {
            throw new DeleteException("Could not delete user.", $e);
        }
    }
}
