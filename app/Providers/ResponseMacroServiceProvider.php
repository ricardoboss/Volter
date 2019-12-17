<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\ApiErrorCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

/**
 * Class ResponseMacroServiceProvider.
 */
class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /*
         * Returns a successful api response.
         *
         * @param mixed $data The data which should be included in the response.
         * @param array|null $messages (optional) Any messages to be sent with the response.
         * @instantiated
         */
        Response::macro('success', function ($data, ?array $messages = null) {
            $responseData = [
                'success' => true,
                'data' => $data,
            ];

            if ($messages) {
                $responseData['messages'] = $messages;
            }

            /* @var Response $this */
            return $this->json($responseData);
        });

        /*
         * Returns a failed api response.
         *
         * @param ApiErrorCode $code The error which should be included in the response.
         * @param int $status (optional) The response status code.
         * @param array|null $messages (optional) Any messages to be sent with the response.
         * @param mixed $data (optional) Data which should be included in the response.
         * @return JsonResponse
         */
        Response::macro('failed', function (ApiErrorCode $code, int $status = 403, ?array $messages = null, $data = null) {
            $data = [
                'success' => false,
                'data' => $data,
                'error' => $code,
            ];

            if ($messages) {
                $data['messages'] = $messages;
            }

            /* @var Response $this */
            return $this->json($data, $status);
        });

        /*
         * Returns an empty api response.
         *
         * @param array|null $messages (optional) Any messages to be sent with the response.
         * @return JsonResponse
         */
        Response::macro('empty', function (?array $messages = null) {
            $responseData = [
                'success' => true,
            ];

            if ($messages) {
                $responseData['messages'] = $messages;
            }

            /* @var Response $this */
            return $this->json($responseData);
        });

        /*
         * Returns a response with an api access token.
         *
         * @param string $token The access token to include in the response.
         * @return JsonResponse
         */
        Response::macro('access_token', function (string $token, array $messages = []) {
            $responseData = [
                'success' => true,
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                ],
            ];

            // TTL can be infinite (null).
            // CAUTION! Tokens must not have the 'exp' claim if TTL is set to null!
            $ttl = auth()->factory()->getTTL();
            $responseData['data']['expires_at'] = $ttl != null ? now()->addMinutes($ttl)->timestamp : null;

            if ($messages) {
                $responseData['messages'] = $messages;
            }

            /* @var Response $this */
            return $this->json($responseData);
        });
    }
}
