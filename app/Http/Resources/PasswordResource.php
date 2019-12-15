<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Password;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PasswordResource
 *
 * @package App\Http\Resources
 *
 * @mixin Password
 */
class PasswordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'notes' => $this->notes,
            'version' => $this->version,
            'created_at' => isset($this->created_at) ? $this->created_at->format($this->getDateFormat()) : null,
            'created_by' => new UserResource($this->creator),
            'updated_at' => isset($this->updated_at) ? $this->updated_at->format($this->getDateFormat()) : null,
            'updated_by' => new UserResource($this->editor),
            'deleted_at' => isset($this->deleted_at) ? $this->deleted_at->format($this->getDateFormat()) : null,
            'deleted_by' => new UserResource($this->deleter),
            'editable' => auth()->user()->can('edit', $this->resource)
        ];
    }
}
