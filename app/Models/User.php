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

namespace App\Models;

use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use jeremykenedy\LaravelRoles\Contracts\HasRoleAndPermission as HasRoleAndPermissionInterface;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission as HasRoleAndPermissionTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User.
 */
class User extends Authenticatable implements JWTSubject, HasRoleAndPermissionInterface, MustVerifyEmail
{
    use Notifiable, HasRoleAndPermissionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier(): int
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'roles' => $this->getRoles()->pluck('slug')->toArray(),
            'permissions' => $this->getPermissions()->pluck('slug')->toArray(),
        ];
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail());
    }

    /**
     * The passwords the user has access to.
     *
     * @return Collection|Password[]
     */
    public function getPasswordsAttribute()
    {
        if ($this->can('viewAll', Password::class)) {
            return Password::all();
        }

        /** @var Password $this */
        $builder = Password::where('created_by', $this->id);

        $shared_access_passwords = DB::table('shared_access')
            ->where('model_type', self::class)
            ->where('model_id', $this->getKey())
            ->distinct()
            ->pluck('password_id')
            ->toArray();

        $builder->orWhereIn('id', $shared_access_passwords);

        return $builder->get();
    }
}
