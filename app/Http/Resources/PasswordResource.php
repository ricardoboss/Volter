<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * Class PasswordResource
 * @package App\Http\Resources
 */
class PasswordResource extends ApiJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
