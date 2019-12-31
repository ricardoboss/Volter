<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Console\Command;

/**
 * Class NotifyUnverifiedUsers.
 */
class Verify extends Command
{
    use ShowModel;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:verify
                                {user : The ID of the user to mark as verified or \'all\' to select all users}
                                {--notify : Only notify the user, do not actually mark the e-mail address as verified}
                                {--force : Ignore value of the email_verified_at field}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark a user\'s e-mail address as verified.';

    /**
     * @var bool whether we are updating multiple users or just one
     */
    private $is_mass_updating = false;

    /**
     * Execute the console command.
     */
    public function handle(): bool
    {
        $id = $this->argument('user');

        if ($id === 'all') {
            $this->is_mass_updating = true;

            $it = User::all()->getIterator();
            $result = true;

            foreach ($it as $user) {
                $result = $result && $this->verifyUser($user);
            }

            return $result;
        }
        $user = User::whereId($id)->firstOrFail();

        return $this->verifyUser($user);
    }

    /**
     * Handle this command if one user is specified.
     */
    private function verifyUser(User $user): bool
    {
        if (!$this->hasOption('force') && $user->hasVerifiedEmail()) {
            $this->warn("User {$user->name} has already verified their e-mail address ({$user->email}).");

            return true;
        }

        if ($this->hasOption('notify')) {
            $user->sendEmailVerificationNotification();

            $this->info("User {$user->name} has successfully been notified to verify their e-mail address ({$user->email}).");
        } else {
            if ($user->markEmailAsVerified()) {
                event(new Verified($user));

                if ($this->is_mass_updating) {
                    $this->info("E-mail address {$user->email} has been marked as verified.");
                } else {
                    $user->refresh();

                    $this->info("User successfully verified:");
                    $this->show($user, ['ID', 'name', 'email', 'email_verified_at']);
                }
            } else {
                $this->error("Could not mark e-mail address as verified: {$user->email}");

                return false;
            }
        }

        return true;
    }
}
