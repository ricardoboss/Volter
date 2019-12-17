<?php

use ricardoboss\Database\Migrations\RolesMigration;

class AttachViewSelfPasswordsToUser extends RolesMigration
{
    protected $toAttach = [
        'user' => ['password.view.self'],
    ];
}
