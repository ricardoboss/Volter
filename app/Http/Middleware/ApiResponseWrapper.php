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
        $original = $response->getOriginalContent();
        $content = [
            'success' => $response->isSuccessful(),
            'data' => $original->toArray(),
        ];

        $jsonContent = json_encode($content, JsonResponse::DEFAULT_ENCODING_OPTIONS);
        $response->setContent($jsonContent);

        return $response;
    }
}
