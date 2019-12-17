<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ApiErrorCode;
use App\Http\Resources\PasswordResource;
use App\Models\Password;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
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
     */
    public function create()
    {
        // TODO: create password from request data
    }

    /**
     * Returns the specified password.
     */
    public function view(Password $password): PasswordResource
    {
        return new PasswordResource($password, true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Password $password)
    {
        // TODO: modify password
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Password $password)
    {
        try {
            if ($password->delete()) {
                return response()->empty();
            }
        } catch (Exception $ignored) { /* Only occurs if the primary key is not defined in the model. */
        }

        return response()->failed(ApiErrorCode::delete_failed());
    }

    /**
     * Share access to a password.
     */
    public function share(Password $password)
    {
        // TODO: implement sharing of passwords
    }

    /**
     * Destroy the specified resource from storage.
     */
    public function destroy(Password $password): JsonResponse
    {
        if ($password->forceDelete()) {
            return response()->empty();
        }

        return response()->failed(ApiErrorCode::delete_failed());
    }
}
