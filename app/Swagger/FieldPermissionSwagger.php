<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;


class FieldPermissionSwagger
{
    /**
     * @OA\Get(
     *     path="/api/models/{model}",
     *     summary="Получить все поля модели",
     *     tags={"Fields"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="model",
     *         in="path",
     *         required=true,
     *         description="Название модели (например, users)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Список полей модели")
     * )
     */
    public function getModelFields(){}

    /**
     * @OA\Get(
     *     path="/api/permissionss",
     *     summary="Получить текущие доступы к полям",
     *     tags={"Fields"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(response=200, description="Список доступов")
     * )
     */
    public function getPermissions(){}

    /**
     * @OA\Post(
     *     path="/api/permissionss",
     *     summary="Обновить доступ к полям",
     *     tags={"Fields"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="role", type="string", example="manager"),
     *             @OA\Property(property="model", type="string", example="users"),
     *             @OA\Property(
     *                 property="fields",
     *                 type="object",
     *                 example={"email": {"is_visible": 0}, "name": {"is_visible": 1}}
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Доступы обновлены")
     * )
     */
    public function updatePermissions(){}

}
