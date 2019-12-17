<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\ApiErrorCode;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class Handler.
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @throws Exception
     */
    public function report(Exception $exception): void
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @return Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param Request $request
     * @return JsonResponse
     */
    protected function prepareJsonResponse($request, Exception $e)
    {
        $status = $this->isHttpException($e) ? $e->getStatusCode() : 500;
        $error = ApiErrorCode::exception();
        if ($status == 401) {
            $error = ApiErrorCode::unauthenticated();
        } elseif ($status == 403) {
            $error = ApiErrorCode::unauthorized();
        } elseif ($status == 404) {
            $error = ApiErrorCode::not_found();
        } elseif ($status == 429) {
            $error = ApiErrorCode::too_many_requests();
        } elseif ($status >= 500) {
            $error = ApiErrorCode::server_error();
        }

        return new JsonResponse(
            [
                'success' => false,
                'result' => $this->convertExceptionToArray($e),
                'error' => $error,
                'messages' => [$e->getMessage()],
            ],
            $status,
            $this->isHttpException($e) ? $e->getHeaders() : [],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
    }
}
