<?php

namespace App\Swagger\Performer;

use OpenApi\Annotations as OA;

class PerformerSwagger
{
    /**
     * @OA\Post(
     *     path="/api/performers/register",
     *     summary="Регистрация нового исполнителя",
     *     tags={"Performer"},
     *
     *     @OA\Parameter(name="first_name", in="query", required=true, @OA\Schema(type="string", example="Алексей")),
     *     @OA\Parameter(name="last_name", in="query", required=true, @OA\Schema(type="string", example="Иванов")),
     *     @OA\Parameter(name="email", in="query", required=true, @OA\Schema(type="string", format="email", example="aleksey@example.com")),
     *     @OA\Parameter(name="phone", in="query", required=true, @OA\Schema(type="string", example="992901234567")),
     *     @OA\Parameter(name="division_id", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="city_id", in="query", required=false, @OA\Schema(type="integer", example=2)),
     *     @OA\Parameter(name="promo_code", in="query", required=false, @OA\Schema(type="string", example="PROMO2025")),
     *     @OA\Parameter(name="passport_serials", in="query", required=false, @OA\Schema(type="string", example="AB1234567")),
     *     @OA\Parameter(name="driver_license_serials", in="query", required=false, @OA\Schema(type="string", format="date", example="2020-06-15")),
     *     @OA\Parameter(name="expirated_driver_license", in="query", required=false, @OA\Schema(type="string", format="date", example="2030-06-15")),
     *     @OA\Parameter(name="expirated_passport", in="query", required=false, @OA\Schema(type="string", format="date", example="2035-06-15")),
     *     @OA\Parameter(name="address", in="query", required=false, @OA\Schema(type="string", example="г. Москва, ул. Ленина, д.10")),
     *     @OA\Parameter(name="fcm_token", in="query", required=false, @OA\Schema(type="string", example="token123456789")),
     *     @OA\Parameter(name="register_from", in="query", required=false, @OA\Schema(type="string", example="mobile_app")),
     *     @OA\Parameter(name="dop_info", in="query", required=false, @OA\Schema(type="string", example="Дополнительная информация")),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Исполнитель успешно зарегистрирован"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     )
     * )
     */
    public function register() {}
}
