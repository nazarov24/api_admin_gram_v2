<?php

namespace App\Swagger\Roles;

use OpenApi\Annotations as OA;


class PermisionRoleSwagger
{

      /**
     * Получить разрешения пользователя
     * @OA\Get(
     *     path="/api/role/permissions",
     *     summary="Получить разрешения пользователя",
     *     tags={"Assign permissions role"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response=200,
     *         description="Разрешения пользователя",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(type="string", example="edit-posts")
     *         )
     *     )
     * )
     */

    public function getPermissions(){}

   /**
     * Назначить разрешения роли и всем пользователям с этой ролью
     * @OA\Post(
     *     path="/api/role/{id}/permissions",
     *     summary="Назначить разрешения роли и пользователям",
     *     tags={"Assign permissions role"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID роли",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"permissions"},
     *             @OA\Property(property="permissions", type="array", @OA\Items(type="integer", example=1))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Разрешения успешно назначены",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Permissions assigned successfully.")
     *         )
     *     )
     * )
     */


    public function assignPermissions(){}




   /**
     * Удалить разрешение по ID у пользователя
     * @OA\Delete(
     *     path="/api/role/{user_id}/permissions/{permission_id}",
     *     summary="Удалить разрешение по ID у пользователя",
     *     tags={"Assign permissions role"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID роля",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="permission_id",
     *         in="path",
     *         required=true,
     *         description="ID разрешения",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Разрешение удалено",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Permission removed successfully.")
     *         )
     *     )
     * )
     */


    public function removePermissionById(){}



  /**
   * @OA\Post(
   *     path="/api/roles/{role_id}/subsections",
   *     summary="Назначить роль на несколько подразделов",
   *     tags={"Section"},
   *     security={{ "bearerAuth":{} }},
   *     @OA\Parameter(
   *         name="role_id",
   *         in="path",
   *         required=true,
   *         description="ID роли",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             required={"subsection_ids"},
   *             @OA\Property(
   *                 property="subsection_ids",
   *                 type="array",
   *                 @OA\Items(type="integer"),
   *                 example={1, 2, 3}
   *             )
   *         )
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Роль успешно назначена на подразделы",
   *         @OA\JsonContent(
   *             @OA\Property(property="message", type="string", example="Роль успешно привязана к подразделам."),
   *             @OA\Property(
   *                 property="role",
   *                 type="object",
   *                 @OA\Property(property="id", type="integer", example=2),
   *                 @OA\Property(property="name", type="string", example="Admin")
   *             ),
   *             @OA\Property(
   *                 property="subsections",
   *                 type="array",
   *                 @OA\Items(
   *                     type="object",
   *                     @OA\Property(property="id", type="integer", example=1),
   *                     @OA\Property(property="name", type="string", example="User Management")
   *                 )
   *             )
   *         )
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="Роль или подраздел(ы) не найдены",
   *         @OA\JsonContent(
   *             @OA\Property(property="message", type="string", example="Подразделы не найдены.")
   *         )
   *     )
   * )
   */
  public function assignRoleToSubsections(){}


}
