<?php
declare(strict_types=1);

namespace App\Console\Commands\Voltor;

use App\Console\Commands\ShowModel;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Class Setup
 *
 * @package App\Console\Commands\Voltor
 */
class Setup extends Command
{
    use ShowModel;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'v:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The setup command for Voltor.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->warn(implode(PHP_EOL, [
            "The setup will automatically DELETE your current database and set up roles and permissions afterwards.",
            "This will overwrite any role and permission settings you have made and IRREVERSIBLY delete all data.",
            "We will also set up the new master user (a super admin)."
        ]));

        if (!$this->confirm("Are you sure you understood and want to continue?"))
            return false;

        $permissions = [
            'view any password',
            'create passwords',
            'assign admins',
            'create users',
        ];

        $roles = ['master', 'admin', 'user'];

        $assigns = [
            'master' => [
                'view any password',
                'create users',
                'create passwords',
                'assign admins',
            ],
            'admin' => [
                'view any password',
                'create users',
                'create passwords'
            ],
            'user' => [
                'create passwords',
            ]
        ];

        $this->warn("Refreshing database...");

        $this->call("migrate:fresh");

        $this->info("Adding permissions...");

        foreach ($permissions as $permission)
            Permission::create(['name' => $permission]);

        $this->info("Adding roles...");

        foreach ($roles as $i => $role)
            $roles[$i] = Role::create(['name' => $role]);

        $this->info("Assigning permissions to roles...");

        foreach ($roles as $role) {
            if (!array_key_exists($role->name, $assigns))
                continue;

            $permissions = $assigns[$role->name];
            $role->syncPermissions($permissions);
        }

        $this->info("Now we will set up the master user.");

        $user = new User();
        $user->name = $this->ask("Your name");
        $user->email = $this->ask("Your e-mail address");
        $user->password = Hash::make($this->secret("Your password (hidden)"));
        $user->email_verified_at = now();

        $user->save();
        $user->refresh();

        $user->assignRole('master');

        $this->show($user, ['id', 'name', 'email']);

        $this->info("Master user created.");

        return true;
    }
}
