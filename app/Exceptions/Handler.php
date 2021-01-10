<?php

namespace App\Exceptions;

use App\Listeners\LoggingListener;
use App\Models\Log;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Log\Events\MessageLogged;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;
use JsonSerializable;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use function GuzzleHttp\Psr7\str;

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
     * The unique incident ID code
     *
     * @var string|bool
     */
    protected $incidentCode = false;

    /**
     * Report or log an exception.
     *
     * @param \Throwable $exception
     * @return void
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
        $this->incidentCode = Str::random(12);
        $listener = $this->container->make(LoggingListener::class);
        $listener->events->map(function (MessageLogged $logged) {
            $logged->context = collect($logged->context)->map(function ($item) {
                if ($item instanceof JsonSerializable) {
                    return $item;
                }

                return (string)$item;
            });
            //Log::addLog(Log::TYPE_GENERAL, $logged->message, $logged->context, $this->incidentCode, request()->fullUrl());
            return $logged;
        });
//        Storage::disk('local')->put("incident\\{$this->incidentCode}.json", $listener->events->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
//        if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
//            //
//        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json(['message' => $exception->getMessage()], 401)
            : redirect()->guest(route('user.login'));
    }

    /**
     * Render the given HttpException.
     *
     * @param \Throwable
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(Throwable $e)
    {
        $this->registerErrorViewPaths();
        if (view()->exists($view = "errors::{$e->getStatusCode()}")) {
            return response()->view($view, [
                'errors' => new ViewErrorBag,
                'exception' => $e,
                'incidentCode' => $this->incidentCode ?? false,
            ], $e->getStatusCode(), $e->getHeaders());
        }
        return $this->convertExceptionToResponse($e);
    }
}
