<?php

use ricardoboss\Database\Migrations\RolesMigration;

class AddUserViewPermissions extends RolesMigration
{
    protected $permissions = [
        [
            'name' => "View any user",
            'slug' => "user.view.any",
            'description' => "permission to view any user"
        ]
    ];

    protected $toAttach = [
        'admin' => [
            'user.view.any'
        ]
    ];
}
