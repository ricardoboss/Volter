<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * Class PasswordCollection
 * @package App\Http\Resources
 */
class PasswordCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = 'App\Models\Password';

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
