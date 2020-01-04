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

use ricardoboss\Database\Migrations\RolesMigration;

/**
 * Class SeedRolesAndPermissions.
 */
class SeedRolesAndPermissions extends RolesMigration
{
    protected $roles = [
        [
            'name' => 'Admin',
            'description' => 'Volter admin. Manages users and has access to all passwords.',
            'level' => 100,
        ],
        [
            'name' => 'User',
            'description' => 'Volter user. Can create and share access to passwords.',
            'level' => 10,
        ],
    ];

    protected $permissions = [
        [
            'name' => 'Create new users',
            'slug' => 'user.create',
            'description' => 'permission to create new users',
        ],
        [
            'name' => 'List all users',
            'slug' => 'user.list.any',
            'description' => 'permission to list any existing user',
        ],
        [
            'name' => 'Modify user itself',
            'slug' => 'user.edit.self',
            'description' => 'permission to modify the authenticated user',
        ],
        [
            'name' => 'Modify any user',
            'slug' => 'user.edit.any',
            'description' => 'permission to modify any existing user',
        ],
        [
            'name' => 'Delete user itself',
            'slug' => 'user.delete.self',
            'description' => 'permission to delete the authenticated user',
        ],
        [
            'name' => 'Delete any user',
            'slug' => 'user.delete.any',
            'description' => 'permission to delete any existing user',
        ],
        [
            'name' => 'Create new passwords',
            'slug' => 'password.create',
            'description' => 'permission to create new passwords',
        ],
        [
            'name' => 'List all self-created passwords',
            'slug' => 'password.list.self',
            'description' => 'permission to list all passwords created by the authenticated user',
        ],
        [
            'name' => 'List any password',
            'slug' => 'password.list.any',
            'description' => 'permission to list any existing password',
        ],
        [
            'name' => 'Modify self-created passwords',
            'slug' => 'password.edit.self',
            'description' => 'permission to modify any password created by the authenticated user',
        ],
        [
            'name' => 'Modify any password',
            'slug' => 'password.edit.any',
            'description' => 'permission to modify any existing password',
        ],
        [
            'name' => 'Delete self-created password',
            'slug' => 'password.delete.self',
            'description' => 'permission to (soft-)delete any password created by the authenticated user',
        ],
        [
            'name' => 'Delete any password',
            'slug' => 'password.delete.any',
            'description' => 'permission to (soft-)delete any existing password',
        ],
        [
            'name' => 'Destroy self-created password',
            'slug' => 'password.destroy.self',
            'description' => 'permission to permanently destroy previously deleted passwords created by the authenticated user',
        ],
        [
            'name' => 'Destroy any password',
            'slug' => 'password.destroy.any',
            'description' => 'permission to permanently destroy any previously deleted passwords',
        ],
        [
            'name' => 'Share self-created passwords',
            'slug' => 'password.share.self',
            'description' => 'permission to share access to any password created by the authenticated user',
        ],
        [
            'name' => 'Share any password',
            'slug' => 'password.share.any',
            'description' => 'permission to share access to any existing password',
        ],
        [
            'name' => 'Promote users',
            'slug' => 'user.promote',
            'description' => 'permission to promote users to admins',
        ],
        [
            'name' => 'Demote admins',
            'slug' => 'admin.demote',
            'description' => 'permission to demote admins to users',
        ],
    ];

    protected $toAttach = [
        'admin' => [
            'user.create',
            'user.list.any',
            'user.edit.any',
            'user.delete.any',
            'password.list.any',
            'password.edit.any',
            'password.delete.any',
            'password.destroy.any',
            'password.share.any',
        ],
        'user' => [
            'user.edit.self',
            'user.delete.self',
            'password.create',
            'password.list.self',
            'password.edit.self',
            'password.delete.self',
            'password.share.self',
        ],
    ];
}
