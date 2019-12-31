<?php
declare(strict_types=1);

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
