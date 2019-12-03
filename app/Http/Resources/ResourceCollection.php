<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection as Collection;

/**
 * Class ResourceCollection
 * @package App\Http\Resources
 */
class ResourceCollection extends Collection
{
    /**
     * Transform the resource into a JSON array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'success' => true,
            'result' => parent::toArray($request),
            'messages' => [],
            'errors' => [],
        ];
    }
}
