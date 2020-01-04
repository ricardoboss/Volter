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

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ApiResponseWrapper.
 */
class ApiResponseWrapper
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);
        $content = [
            'success' => $response->isSuccessful(),
        ];

        if ($response instanceof JsonResponse) {
            /** @var JsonResponse $response */
            $data = $response->getData(true);

            if (is_array($data) && array_key_exists('data', $data)) {
                $content = array_merge($content, $data);
            } elseif (is_object($data) && property_exists($data, 'data')) {
                $content = array_merge($content, json_decode(json_encode($data), true));
            } else {
                $content['data'] = $data;
            }
        } else {
            $content['data'] = $response->getOriginalContent();
        }

        $jsonContent = json_encode($content, JsonResponse::DEFAULT_ENCODING_OPTIONS);
        $response->setContent($jsonContent);

        return $response;
    }
}
