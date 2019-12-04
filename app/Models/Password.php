<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Password
 *
 * @property string $id
 * @property int $version
 * @property string $name
 * @property string $notes
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $deleted_by
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Password newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Password newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Password onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Password query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Password whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Password whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Password whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Password whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Password whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Password whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Password whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Password whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Password whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Password whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Password whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Password withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Password withoutTrashed()
 * @mixin \Eloquent
 */
class Password extends Model
{
    use SoftDeletes;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'notes',
        'value'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'value'
    ];
}
