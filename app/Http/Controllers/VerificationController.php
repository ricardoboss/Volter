<?php
declare(strict_types=1);

/*
 * Copyright (C) 2019 Ricardo Boss
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

/**
 * Class VerificationController.
 */
class VerificationController extends Controller
{
    /**
     * VerificationController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @var string the path to redirect to after verification
     */
    protected $redirectTo = '/';

    /**
     * Check if the currently authenticated user has verified their e-mail address.
     */
    public function check(): bool
    {
        /** @var User $user */
        $user = auth()->user();

        return $user->hasVerifiedEmail();
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @throws AuthorizationException
     */
    public function verify(Request $request): void
    {
        if (!hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            throw new AuthorizationException;
        }

        if (!hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return;
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request): void
    {
        if ($request->user()->hasVerifiedEmail()) {
            return;
        }

        $request->user()->sendEmailVerificationNotification();
    }
}
