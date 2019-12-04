<?php
declare(strict_types=1);

namespace App\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;

/**
 * Class RolesMigration
 *
 * @package App\Database\Migrations
 */
abstract class RolesMigration extends Migration
{
    protected $roles = [];
    protected $permissions = [];
    protected $toAttach = [];
    protected $toDetach = [];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // TODO: update existing models (levels, names, descriptions)
        $this->addPermissions();
        $this->addRoles();
        $this->syncPermissions('attachPermission', $this->toAttach);
        $this->syncPermissions('detachPermission', $this->toDetach);
    }

    public function addPermissions(): void
    {
        foreach ($this->permissions as $permission) {
            if (!array_key_exists('slug', $permission))
                $permission['slug'] = Str::slug($permission['name'], '.');

            // do not re-create existing models
            if (config('roles.models.permission')::where('slug', $permission['slug'])->exists())
                continue;

            config('roles.models.permission')::create($permission);
        }
    }

    public function addRoles(): void
    {
        foreach ($this->roles as $role) {
            if (!array_key_exists('slug', $role))
                $role['slug'] = Str::slug($role['name'], '.');

            config('roles.models.role')::create($role);
        }
    }

    /**
     * @param string $method The method to call on the role. Can be either 'attachPermission' or 'detachPermission'
     * @param string[][] $toSync Permissions to sync to a role. ['role' => ['permission1', 'permission2']]
     */
    public function syncPermissions(string $method, $toSync): void
    {
        foreach ($toSync as $roleSlug => $permissionSlugs) {
            /** @var Role $role */
            $role = config('roles.models.role')::where('slug', $roleSlug)->first();
            if ($role === null)
                continue;

            foreach ($permissionSlugs as $permissionSlug) {
                /** @var Permission $permission */
                $permission = config('roles.models.permission')::where('slug', $permissionSlug)->first();
                if ($permission === null)
                    continue;

                $role->{$method}($permission->{$permission->getKeyName()});
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->syncPermissions('detachPermission', $this->toAttach);
        $this->syncPermissions('attachPermission', $this->toDetach);
        $this->removeRoles();
        $this->removePermissions();
    }

    public function removeRoles(): void
    {
        foreach ($this->roles as $role) {
            if (!array_key_exists('slug', $role))
                $role['slug'] = Str::slug($role['name'], '.');

            config('roles.models.role')::where('slug', $role['slug'])->forceDelete();
        }
    }

    public function removePermissions(): void
    {
        foreach ($this->permissions as $permission) {
            if (!array_key_exists('slug', $permission))
                $permission['slug'] = Str::slug($permission['name'], '.');

            config('roles.models.permission')::where('slug', $permission['slug'])->forceDelete();
        }
    }
}
