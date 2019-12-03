<?php
declare(strict_types=1);

namespace App\Providers;

use App\Enums\ApiErrorCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

/**
 * Class ResponseMacroServiceProvider
 *
 * @package App\Providers
 */
class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Returns a successful api response.
         *
         * @param mixed $result The result which should be included in the response.
         * @param array $messages (optional) Any messages to be sent with the response.
         * @instantiated
         */
        Response::macro('success', function ($result, array $messages = []) {
            /** @var Response $this */
            return $this->json([
                'success' => true,
                'result' => $result,
            ]);
        });

        /**
         * Returns a failed api response.
         *
         * @param ApiErrorCode $code The error which should be included in the response.
         * @param int $status (optional) The response status code.
         * @param array $messages (optional) Any messages to be sent with the response.
         * @return JsonResponse
         */
        Response::macro('failed', function (ApiErrorCode $code, int $status = 403, array $messages = []) {
            /** @var Response $this */
            return $this->json([
                'success' => false,
                'result' => null,
                'messages' => $messages,
                'error' => $code,
            ], $status);
        });

        /**
         * Returns an empty api response.
         *
         * @param array $messages (optional) Any messages to be sent with the response.
         * @param array $errors (optional) Any errors to be sent with the response.
         * @return JsonResponse
         */
        Response::macro('empty', function (array $messages = []) {
            /** @var Response $this */
            return $this->json([
                'success' => true,
                'result' => null,
                'messages' => $messages,
            ]);
        });

        /**
         * Returns a response with an api access token.
         *
         * @param string $token The access token to include in the response.
         * @return JsonResponse
         */
        Response::macro('access_token', function (string $token, array $messages = []) {
            /** @var Response $this */
            return $this->json([
                'success' => true,
                'result' => [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                ],
                'messages' => $messages,
            ]);
        });
    }
}
