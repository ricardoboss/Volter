<?php

declare(strict_types=1);

namespace App\Http\Controllers;

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

        // TODO: create password from request data

        return new PasswordResource(new Password());
    }

    /**
     * Returns the specified password.
     *
     * @throws AuthorizationException If the user cannot view the specified password.
     */
    public function view(Password $password): PasswordResource
    {
        $this->authorize('view', $password);

        return new PasswordResource($password, true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @throws AuthorizationException If the user cannot update the password.
     */
    public function update(Password $password): PasswordResource
    {
        $this->authorize('update', $password);

        // TODO: modify password

        return new PasswordResource($password);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException If the user cannot delete the given password.
     * @throws Exception If the primary key is not defined on the model.
     */
    public function delete(Password $password): ?bool
    {
        $this->authorize('delete', $password);

        return $password->delete();
    }

    /**
     * Share access to a password.
     *
     * @throws AuthorizationException If the user cannot share the given password.
     */
    public function share(Password $password): void
    {
        $this->authorize('share', $password);
        // TODO: implement sharing of passwords
    }

    /**
     * Destroy the specified resource from storage.
     *
     * @throws AuthorizationException If the user cannot destroy the given password.
     */
    public function destroy(Password $password): ?bool
    {
        $this->authorize('destroy', $password);

        return $password->forceDelete();
    }
}
