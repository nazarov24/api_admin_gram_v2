<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * Список исключений, которые не требуют логирования.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * Регистрирует обработчики исключений.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $exception) {
            //
        });
    }

    /**
     * Рендерит исключение для HTTP-ответа.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // Обработка исключений AuthenticationException
        if ($exception instanceof AuthenticationException) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Обработка исключений RouteNotFoundException
        if ($exception instanceof RouteNotFoundException) {
            return response()->json(['message' => 'Route not found'], 404);
        }


        // Для остальных исключений, передаем родительский рендер
        return parent::render($request, $exception);
    }
}
