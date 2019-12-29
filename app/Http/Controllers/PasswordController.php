<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\DeleteException;
use App\Exceptions\UpdateException;
use App\Http\Resources\PasswordResource;
use App\Models\Password;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class PasswordController.
 */
class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = auth()->user();

        return PasswordResource::collection($user->passwords->paginate(20));
    }

    /**
     * Create a new password.
     *
     * @throws AuthorizationException
     */
    public function create(): PasswordResource
    {
        $this->authorize('create', Password::class);

        $values = request()->input();
        $password = Password::create($values);

        return new PasswordResource($password);
    }

    /**
     * Returns the specified password.
     *
     * @throws AuthorizationException if the user cannot view the specified password
     */
    public function view(Password $password): PasswordResource
    {
        $this->authorize('view', $password);

        return new PasswordResource($password, true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws AuthorizationException if the user cannot update the password
     * @throws UpdateException if updating the values in database fails
     */
    public function update(Password $password): PasswordResource
    {
        // fetch all values from db
        $password->refresh();

        $this->authorize('update', $password);

        // get new values from request
        $values = request()->input();

        // update values in database
        if (!$password->update($values)) {
            throw new UpdateException("Updating values in database failed.");
        }

        return new PasswordResource($password);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException if the user cannot delete the given password
     * @throws DeleteException if deleting of the password fails
     */
    public function delete(Password $password): ?bool
    {
        $this->authorize('delete', $password);

        try {
            return $password->delete();
        } catch (Exception $e) {
            throw new DeleteException("Could not delete password.", $e);
        }
    }

    /**
     * Share access to a password.
     *
     * @throws AuthorizationException if the user cannot share the given password
     */
    public function share(Password $password): void
    {
        $this->authorize('share', $password);

        // TODO: implement sharing of passwords
    }

    /**
     * Destroy the specified resource from storage.
     *
     * @throws AuthorizationException if the user cannot destroy the given password
     * @throws DeleteException if the password cannot be destroyed
     */
    public function destroy(Password $password): ?bool
    {
        $this->authorize('destroy', $password);

        try {
            return $password->forceDelete();
        } catch (Exception $e) {
            throw new DeleteException("Could not destroy password.", $e);
        }
    }
}
