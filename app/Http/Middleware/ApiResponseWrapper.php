<?php
declare(strict_types=1);

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
