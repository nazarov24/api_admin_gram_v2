<?php

namespace App\Swagger\Employee;

use App\Http\Requests\EmployeeRequest\StoreRequest;
use OpenApi\Annotations as OA;

class EmployeeSwagger {

  /**
   * @OA\Post(
   *     path="/api/employees/users",
   *     summary="Создание нового пользователя",
   *     tags={"Employee"},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\MediaType(
   *             mediaType="multipart/form-data",
   *             @OA\Schema(
   *                 required={"division_id", "first_name", "last_name", "phone", "email", "avatar", "role"},
   *                 @OA\Property(property="division_id", type="integer", example=1),
   *                 @OA\Property(property="first_name", type="string", example="John"),
   *                 @OA\Property(property="last_name", type="string", example="Doe"),
   *                 @OA\Property(property="patronymic", type="string", example="Ivanovich"),
   *                 @OA\Property(property="phone", type="string", example="992901234567"),
   *                 @OA\Property(property="second_phone", type="string", example="992931234567"),
   *                 @OA\Property(property="birth_date", type="string", format="date", example="1990-01-01"),
   *                 @OA\Property(property="gender", type="integer", example=0, enum={0,1}),
   *                 @OA\Property(property="email", type="string", format="email", example="john@example.com"),
   *                 @OA\Property(property="avatar", type="string", format="binary"),
   *                 @OA\Property(property="role", type="string", example="admin")
   *             )
   *         )
   *     ),
   *     @OA\Response(response=201, description="Пользователь создан"),
   *     @OA\Response(response=422, description="Ошибка валидации")
   * )
   */

  public function register(){}


}