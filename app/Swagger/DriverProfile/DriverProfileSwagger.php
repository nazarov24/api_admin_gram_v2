<?php

namespace App\Swagger\DriverProfile;

use App\Http\Requests\EmployeeRequest\StoreRequest;
use OpenApi\Annotations as OA;

class DriverProfileSwagger {

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     ** path="/api/driver-profiles",
     *   tags={"Anketa Drivers"},
     *   summary="Create driver profile",
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
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="last_name",
     *     in="query",
     *     required=false,
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
     *     name="type_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="integer"
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
     *     name="dop_phone",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="from_time",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="before_time",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="comment",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="gender",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="date_of_birth",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="promo_code",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="type_earning_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="driver_license_type_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="integer"
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
     *     name="address",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="email",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *  @OA\Parameter(
     *     name="color_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *  @OA\Parameter(
     *     name="model_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *  @OA\Parameter(
     *     name="year",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *  @OA\Parameter(
     *     name="car_number",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *     @OA\Response(response=200, description="Success",@OA\MediaType(mediaType="application/json",)),
     *     @OA\Response(response=401,description="Unauthenticated"),
     *     @OA\Response(response=400,description="Bad Request"),
     *     @OA\Response(response=404,description="not found"),
     *     @OA\Response(response=403,description="Forbidden")
     *)
     **/

     public function store(){}
 
     /**
      * @OA\Get(
      *     summary="Get driver profile info by id",
      *     path="/api/driver-profiles/{driver_profile_id}/edit",
      *     operationId="/api/driver-profiles/{driver_profile_id}/edit",
      *     tags={"Anketa Drivers"},
      *     security={{"bearerAuth":{}}},
      *
      *   @OA\Parameter(
      *     name="driver_profile_id",
      *     in="path",
      *     required=true,
      *     @OA\Schema
      *          (type="integer")
      *     ),
      * @OA\Response(response="200", description="Display a listing of clients."),
      * @OA\Response(response=401, description="Unauthorized"),
      * @OA\Response(response=404, description="Not Found")
      * )
      */
 
     public function edit(){}
 
     /**
      * Update the specified resource in storage.
      *
      * @param \Illuminate\Http\Request $request
      * @param int $id
      * @return \Illuminate\Http\Response
      */
     /**
      * @OA\Patch(
      ** path="/api/driver-profiles/{driver_profile_id}",
      *   tags={"Anketa Drivers"},
      *   summary="Update driver profile",
      *   security={{"bearerAuth":{}}},
      *
      *   @OA\Parameter(
      *     name="driver_profile_id",
      *     in="path",
      *     required=true,
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\Parameter(
      *     name="division_id",
      *     in="query",
      *     required=true,
      *     @OA\Schema(type="integer")
      *   ),
      *   @OA\Parameter(
      *     name="first_name",
      *     in="query",
      *     required=false,
      *     @OA\Schema(
      *          type="string"
      *     )
      *   ),
      *   @OA\Parameter(
      *     name="last_name",
      *     in="query",
      *     required=false,
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
      *     name="type_id",
      *     in="query",
      *     required=false,
      *     @OA\Schema(
      *          type="integer"
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
      *     name="dop_phone",
      *     in="query",
      *     required=false,
      *     @OA\Schema(
      *          type="string"
      *     )
      *   ),
      *   @OA\Parameter(
      *     name="from_time",
      *     in="query",
      *     required=false,
      *     @OA\Schema(
      *          type="string"
      *     )
      *   ),
      *   @OA\Parameter(
      *     name="before_time",
      *     in="query",
      *     required=false,
      *     @OA\Schema(
      *          type="string"
      *     )
      *   ),
      *   @OA\Parameter(
      *     name="comment",
      *     in="query",
      *     required=false,
      *     @OA\Schema(
      *          type="string"
      *     )
      *   ),
      *   @OA\Parameter(
      *     name="gender",
      *     in="query",
      *     required=false,
      *     @OA\Schema(
      *          type="string"
      *     )
      *   ),
      *   @OA\Parameter(
      *     name="date_of_birth",
      *     in="query",
      *     required=false,
      *     @OA\Schema(
      *          type="string"
      *     )
      *   ),
      *   @OA\Parameter(
      *     name="promo_code",
      *     in="query",
      *     required=false,
      *     @OA\Schema(
      *          type="string"
      *     )
      *   ),
      *   @OA\Parameter(
      *     name="type_earning_id",
      *     in="query",
      *     required=false,
      *     @OA\Schema(
      *          type="string"
      *     )
      *   ),
      *   @OA\Parameter(
      *     name="driver_license_type_id",
      *     in="query",
      *     required=false,
      *     @OA\Schema(
      *          type="integer"
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
      *     name="email",
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
      *     name="address",
      *     in="query",
      *     required=false,
      *     @OA\Schema(
      *          type="string"
      *     )
      *   ),
      *  @OA\Parameter(
      *     name="color_id",
      *     in="query",
      *     required=false,
      *     @OA\Schema(type="integer")
      *   ),
      *  @OA\Parameter(
      *     name="model_id",
      *     in="query",
      *     required=false,
      *     @OA\Schema(type="integer")
      *   ),
      *  @OA\Parameter(
      *     name="year",
      *     in="query",
      *     required=false,
      *     @OA\Schema(type="integer")
      *   ),
      *  @OA\Parameter(
      *     name="car_number",
      *     in="query",
      *     required=false,
      *     @OA\Schema(type="string")
      *   ),
      *     @OA\Response(response=200, description="Success",@OA\MediaType(mediaType="application/json",)),
      *     @OA\Response(response=401,description="Unauthenticated"),
      *     @OA\Response(response=400,description="Bad Request"),
      *     @OA\Response(response=404,description="not found"),
      *     @OA\Response(response=403,description="Forbidden")
      *)
      **/
     public function update(){}
}