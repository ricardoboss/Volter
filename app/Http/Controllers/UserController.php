<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ApiErrorCode;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var User $user */
        //$user = auth()->user();

        // TODO: only return users visible to the authenticated users
        return UserResource::collection(User::all()->paginate(20));
    }

    /**
     * Create a new user.
     */
    public function create()
    {
        // TODO: create user from request data
    }

    /**
     * Returns the specified user.
     */
    public function view(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // TODO: modify user
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(User $user)
    {
        try {
            if ($user->delete())
                return response()->empty();
        } catch (Exception $ignored) {
            /* Only occurs if the primary key is not defined in the model. */
        }

        return response()->failed(ApiErrorCode::delete_failed());
    }
}
