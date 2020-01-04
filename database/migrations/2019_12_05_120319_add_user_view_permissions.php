<?php

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

class AddUserViewPermissions extends RolesMigration
{
    protected $permissions = [
        [
            'name' => 'View any user',
            'slug' => 'user.view.any',
            'description' => 'permission to view any user',
        ],
    ];

    protected $toAttach = [
        'admin' => [
            'user.view.any',
        ],
    ];
}
