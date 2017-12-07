<?php

namespace App\Exceptions;

use App\Http\Middleware\SidebarLoader;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        // Вызов загрузчика данных для боковой панели
        if ($e instanceof NotFoundHttpException) {
            $sbl = new SidebarLoader;
            $sbl->handle($request, function() {});
        }

        //для админке отрисовываем HTTP исключение в особенном шаблоне
        if (($e instanceof HttpException || $e instanceof ModelNotFoundException) && $request->is('admin/*') && Auth::check()) {
            return response()->view('admin.errors.404');
        }
        //для админке отрисовываем ошибки доступа Авторизации исключение в особенном шаблоне
        if($e instanceof AuthorizationException && $request->is('admin/*') && Auth::check()) {
            return response()->view('admin.errors.403', [], 403);
        }
        return parent::render($request, $e);
    }
}
