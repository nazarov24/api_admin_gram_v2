<?php

namespace App\Swagger\Auth;

use OpenApi\Annotations as OA;


class AuthSwagger
{
     /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Авторизация и получение токена",
     *     tags={"Login"},
     *     @OA\Parameter(
     *         name="login",
     *         in="query",
     *         required=true,
     *         description="Email пользователя",
     *         @OA\Schema(type="string", example="992901234568")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         required=true,
     *         description="Пароль пользователя",
     *         @OA\Schema(type="string", example="H7TbJp5r")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Токен аутентификации",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="your-jwt-token-here")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неверные учетные данные",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */

     public function login(){}
 
}
