<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Password;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PasswordResource.
 *
 * @mixin Password
 */
class PasswordResource extends JsonResource
{
    /** @var bool Whether or not to include the value in the resulting array. */
    private $includeValue;

    /**
     * PasswordResource constructor.
     *
     * @param $resource
     */
    public function __construct($resource, bool $includeValue = false)
    {
        parent::__construct($resource);

        $this->includeValue = $includeValue;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'value' => static::when($this->includeValue, $this->value),
            'notes' => $this->notes,
            'version' => $this->version,
            'created_at' => isset($this->created_at) ? $this->created_at->format($this->getDateFormat()) : null,
            'created_by' => new UserResource($this->creator),
            'updated_at' => isset($this->updated_at) ? $this->updated_at->format($this->getDateFormat()) : null,
            'updated_by' => new UserResource($this->editor),
            'deleted_at' => isset($this->deleted_at) ? $this->deleted_at->format($this->getDateFormat()) : null,
            'deleted_by' => new UserResource($this->deleter),
            'editable' => auth()->user()->can('update', $this->resource),
        ];
    }
}
