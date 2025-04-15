<?php

namespace App\Swagger\Orders;

use App\Http\Requests\EmployeeRequest\StoreRequest;
use OpenApi\Annotations as OA;

class JournalOrderSwagger {
   /**
     * @OA\Get(
     *     summary="Order Journals List",
     *     path="/api/orders/journals",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *    @OA\Parameter(
     *     name="filter_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *    @OA\Parameter(
     *     name="filter_id_condition",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *      @OA\Parameter(
     *     name="filter_client_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *    @OA\Parameter(
     *     name="filter_client_id_condition",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *  @OA\Parameter(
     *     name="filter_division_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *        @OA\Parameter(
     *     name="filter_division_id_condition",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="filter_dop_phone",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *    @OA\Parameter(
     *     name="filter_dop_phone_condition",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="filter_from_address",
     *     in="query",
     *      required=false,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="filter_from_address_condition",
     *     in="query",
     *      required=false,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="filter_distance",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_distance_condition",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *  @OA\Parameter(
     *     name="filter_auto_assignment",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *     @OA\Parameter(
     *     name="filter_auto_assignment_condition",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *  @OA\Parameter(
     *     name="filter_not_issued",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *       @OA\Parameter(
     *     name="filter_for_time",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *       @OA\Parameter(
     *     name="filter_date_time",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *
     *   @OA\Parameter(
     *     name="filter_to_address",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *    @OA\Parameter(
     *     name="filter_to_address_condition",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="filter_status_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     name="filter_tariff_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     name="filter_order_type_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     name="filter_from_created_at",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *        type="date-time",
     *        example="10-04-2024 03:00"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_to_created_at",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *         type="date-time",
     *         example="17-04-2024 02:00"
     *     )
     *  ),
     *    @OA\Parameter(
     *     name="filter_from_date_time",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *        type="date-time",
     *        example="10-04-2024 03:00"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_to_date_time",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *         type="date-time",
     *         example="17-04-2024 02:00"
     *     )
     *   ),
     *     @OA\Parameter(
     *      name="filter_full_name",
     *      in="query",
     *      required=false,
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *      name="filter_full_name_condition",
     *      in="query",
     *      required=false,
     *      @OA\Schema(type="string")
     *     ),
     *   @OA\Parameter(
     *     name="filter_car_info",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="filter_car_info_condition",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="filter_info_for_operator",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_info_for_operator_condition",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_info_for_drivers",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_info_for_drivers_condition",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_client_status",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_price",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_price_condition",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_commission_price",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_commission_price_condition",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_payment_type",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_payment_type_condition",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_status",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="filter_status_condition",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *     @OA\Response(response="200", description="Display a listing of projects."),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     */

 public function journals(){}

}
