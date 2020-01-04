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
