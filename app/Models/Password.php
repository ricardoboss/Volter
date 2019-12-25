<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Password.
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
        'raw_value',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'raw_value',
    ];

    /**
     * The user who created this password.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The user who last updated this password.
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * The user who deleted this password.
     */
    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Get the decrypted value of this password.
     *
     * @return mixed
     */
    public function getValueAttribute()
    {
        if (!array_key_exists('raw_value', $this->attributes) ||
            $this->attributes['raw_value'] === null
        ) {
            return null;
        }

        return decrypt($this->attributes['raw_value']);
    }

    /**
     * Set the value of this password after.
     */
    public function setValueAttribute(string $value): void
    {
        $this->attributes['raw_value'] = isset($value) ? encrypt($value) : null;
    }
}
