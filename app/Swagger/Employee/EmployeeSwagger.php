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
   *     @OA\Parameter(name="division_id", in="query", required=true, @OA\Schema(type="integer", example=1)),
   *     @OA\Parameter(name="first_name", in="query", required=true, @OA\Schema(type="string", example="John")),
   *     @OA\Parameter(name="last_name", in="query", required=true, @OA\Schema(type="string", example="Doe")),
   *     @OA\Parameter(name="patronymic", in="query", required=false, @OA\Schema(type="string", example="Ivanovich")),
   *     @OA\Parameter(name="phone", in="query", required=true, @OA\Schema(type="string", example="992901234567")),
   *     @OA\Parameter(name="second_phone", in="query", required=false, @OA\Schema(type="string", example="992931234567")),
   *     @OA\Parameter(name="birth_date", in="query", required=false, @OA\Schema(type="string", format="date", example="1990-01-01")),
   *     @OA\Parameter(name="gender", in="query", required=false, @OA\Schema(type="integer", enum={0, 1}, example=0)),
   *     @OA\Parameter(name="email", in="query", required=true, @OA\Schema(type="string", format="email", example="john@example.com")),
   *     @OA\Parameter(name="role", in="query", required=true, @OA\Schema(type="string", example="admin")),
   *
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\MediaType(
   *             mediaType="multipart/form-data",
   *             @OA\Schema(
   *                 @OA\Property(property="avatar", type="string", format="binary")
   *             )
   *         )
   *     ),
   *     @OA\Response(response=201, description="Пользователь создан"),
   *     @OA\Response(response=422, description="Ошибка валидации")
   * )
   */


  public function register(){}


}
