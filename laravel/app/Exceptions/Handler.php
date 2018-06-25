<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if (request()->segment(1) == 'api' || request()->ajax() || request()->wantsJson()) {
            if ($e instanceof \Illuminate\Http\Exception\HttpResponseException) { //自定义错误返回
                return $e->getResponse();
            }

            $code = $e->getCode() <= 0 || $e->getCode() > 600 ? 500 : $e->getCode();
            $message = $e->getMessage();
            $file = '';

            if ($e instanceof ModelNotFoundException) { //单条数据找不到
                $code = 404;
            } elseif ($e instanceof AuthorizationException) {
                $code = 403;
            } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                $message = $message ?: 'Not Found';
                $code = 404;
            } elseif ($e instanceof HttpException) {  //abort 错误
                $code = $e->getStatusCode();
            } elseif ($e instanceof \Illuminate\Database\QueryException) {
                $code = 500;
            }

            if (env('APP_DEBUG') && $code == 500) {
                $file = str_replace(base_path(), '', array_last(explode('Controllers', $e->getFile()))).':'.$e->getLine();
            }

            return response()->json(array_filter(compact('message', 'file', 'code')), $code);
        }

        return parent::render($request, $e);
    }
}
