<?php

namespace App\Swagger\Client;

use App\Http\Requests\ClientRequest\StoreRequest;
use OpenApi\Annotations as OA;

class ClientSwagger {

/**
 * @OA\Post(
 *     path="/api/client/register",
 *     tags={"Client"},
 *     summary="Регистрация нового клиента",
 *     description="Регистрирует нового клиента и возвращает логин и пароль",
 *     operationId="registerClient",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"first_name", "last_name", "phone", "email", "birth_date", "gender", "device"},
 *                 @OA\Property(property="first_name", type="string", example="Иван"),
 *                 @OA\Property(property="last_name", type="string", example="Иванов"),
 *                 @OA\Property(property="patronymic", type="string", example="Иванович"),
 *                 @OA\Property(property="phone", type="string", example="+992921234567"),
 *                 @OA\Property(property="email", type="string", format="email", example="ivanov@example.com"),
 *                 @OA\Property(property="birth_date", type="string", format="date", example="1990-01-01"),
 *                 @OA\Property(property="gender", type="integer", enum={0,1}, example=0),
 *                 @OA\Property(property="fcm_token", type="string", example="fcm_example_token"),
 *                 @OA\Property(property="device", type="string", example="android"),
 *                 @OA\Property(property="division_id", type="integer", example=1),
 *                 @OA\Property(property="status", type="integer", enum={0,1}, example=1),
 *                 @OA\Property(property="is_online", type="integer", enum={0,1}, example=0),
 *                 @OA\Property(property="dop_info", type="string", example="Дополнительная информация"),
 *                 @OA\Property(property="avatar", type="string", format="binary"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Успешная регистрация",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Клиент успешно зарегистрирован!"),
 *             @OA\Property(property="login", type="string", example="+998901234567"),
 *             @OA\Property(property="password", type="string", example="H8sK9p2T")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Системная ошибка",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Произошла системная ошибка!"),
 *             @OA\Property(property="error", type="string", example="SQLSTATE[23000]: Integrity constraint violation...")
 *         )
 *     )
 * )
 */


  public function register(){}


}
