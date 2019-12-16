<?php

use ricardoboss\Database\Migrations\RolesMigration;

class AddViewPasswordPermissions extends RolesMigration
{
    /**
     * An array of permission definitions. A permission definition is an array which contains at least these keys:
     *   - name: The name of the new permission
     *   - description: A brief description of the permission.
     *
     * Optionally, you can add the key 'slug' which is a url-safe key for the permission.
     *
     * @var string[][]
     */
    protected $permissions = [
        [
            'name' => 'View any password',
            'slug' => 'password.view.any',
            'description' => 'permission to view any password',
        ],
        [
            'name' => 'View self-created passwords',
            'slug' => 'password.view.self',
            'description' => 'permission to view passwords created by the authenticated user',
        ],
    ];
}
