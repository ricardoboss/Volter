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
     */
    public function update(Password $password): PasswordResource
    {
        $this->authorize('update', $password);

        $values = request()->input();

        Password::firstOrFail($password->id)->update($values);

        return new PasswordResource($password);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException if the user cannot delete the given password
     * @throws Exception if the primary key is not defined on the model
     */
    public function delete(Password $password): ?bool
    {
        $this->authorize('delete', $password);

        return $password->delete();
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
     */
    public function destroy(Password $password): ?bool
    {
        $this->authorize('destroy', $password);

        return $password->forceDelete();
    }
}
