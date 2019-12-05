<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * Class PasswordCollection
 * @package App\Http\Resources
 */
class PasswordCollection extends ApiJsonResource
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = PasswordResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
