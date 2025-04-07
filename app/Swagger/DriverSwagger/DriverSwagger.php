<?php

namespace App\Swagger\DriverSwagger;

use App\Http\Requests\EmployeeRequest\StoreRequest;
use OpenApi\Annotations as OA;

class DriverSwagger {

   /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     ** path="/api/drivers/register",
     *   tags={"Drivers"},
     *   summary="Create driver",
     *   security={{"bearerAuth":{}}},
     *
     *   @OA\Parameter(
     *     name="division_id",
     *     in="query",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     name="first_name",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="last_name",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="patronymic",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="phone",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="contact_number",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="integer"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="date_of_birth",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
    *   @OA\Parameter(
     *     name="email",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="serials_number",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="expirated_driver_license",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="gender",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *          type="integer"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="serial_number_passport",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="expirated_passport",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="district_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="integer"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="passport_office_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="integer"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="car_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="integer"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="address",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="dop_info",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *
     *     @OA\Response(response=200, description="Success",@OA\MediaType(mediaType="application/json",)),
     *     @OA\Response(response=401,description="Unauthenticated"),
     *     @OA\Response(response=400,description="Bad Request"),
     *     @OA\Response(response=404,description="not found"),
     *     @OA\Response(response=403,description="Forbidden")
     *)
     **/


  public function store(){}


}