<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use jeremykenedy\LaravelRoles\Contracts\HasRoleAndPermission as HasRoleAndPermissionInterface;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission as HasRoleAndPermissionTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @package App\Models
 */
class User extends Authenticatable implements JWTSubject, HasRoleAndPermissionInterface
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
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The passwords the user has access to.
     */
    public function getPasswordsAttribute()
    {
        if ($this->can('viewAll', Password::class))
            return Password::all();

        /** @var Password $this */
        $builder = Password::where('created_by', $this->id);

        $shared_access_passwords = DB::table('shared_access')
            ->where('model_type', self::class)
            ->where('model_id', $this->getKey())
            ->get(['password_id']);

        $builder->orWhereIn('id', $shared_access_passwords);

        return $builder->get();
    }
}
