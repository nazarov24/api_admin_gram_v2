<?php

namespace App\Services\Order;

use App\Http\Resources\JournalOrderResource;
use App\Models\PerformerTransport;
use App\Models\PushNotifyList;
use App\Models\StateStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Division;
use App\Models\Client;
use App\Models\ClientCard;
use App\Models\ClientPayType;
use App\Models\Employee;
use App\Models\OrderAllowance;
use App\Models\OrderStatus;
use App\Models\Performer;
use App\Models\PerformerOrder;
use App\Models\Tariff;
use App\Models\OrderToAddress;
use App\Models\PerformerCardType;
use App\Models\RequestPerformerToOrder;
use App\Models\TariffAllowance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JournalOrderService
{
    public static function journals(Request $request): JsonResponse
    {
        $limit = 100;
        if (isset($request->limit) && ctype_digit($request->limit) && $request->limit > 0) {
            $limit = $request->limit;
        }
        $orders = Order::query()->with([
            'client:id',
            'division:id',
            'type:id,name',
            'tariff:id',
            'users:id',
            'tariffPrices'
        ]);

        if ($request->has('filter_id') || ($request->filter_id_condition == "nullable" || $request->filter_id_condition == "notNullable")) {
            $column = "orders.id";
            $value = $request->filter_id;
            $condition = null;
            if ($request->has('filter_id_condition')) {
                $condition = $request->filter_id_condition;
            }
            $orders = $orders->FilterInt($column, $condition, $value);
        }

        // Filter phone
        if ($request->has('filter_dop_phone') || ($request->filter_dop_phone_condition == "nullable" || $request->filter_dop_phone_condition == "notNullable")) {
            $column = "dop_phone";
            $value = $request->filter_dop_phone;
            $condition = null;
            if ($request->has('filter_dop_phone_condition')) {
                $condition = $request->filter_dop_phone_condition;
            }

            $orders = $orders->FilterString($column, $condition, $value);
        }

//        if($request->has('filter_phone') || ($request->filter_phone_condition == "nullable" || $request->filter_phone_condition == "notNullable")){
//            $relation = "client";
//            $column = "phone";
//            $value = $request->filter_phone;
//            $condition = null;
//            if ($request->has('filter_phone_condition')){
//                $condition = $request->filter_phone_condition;
//            }
//            $orders = $orders->FilterRelationStringHas($relation,$column, $condition, $value);
//        }

        //filter client_id
        if ($request->has('filter_client_id') || ($request->filter_client_id_condition == "nullable" || $request->filter_client_id_condition == "notNullable")) {
            $relation = "client";
            $column = "id";
            $value = $request->filter_client_id;
            $condition = null;
            if ($request->has('filter_client_id_condition')) {
                $condition = $request->filter_client_id_condition;
            }
            $orders = $orders->FilterRelationIntHas($relation, $column, $condition, $value);
        }

//         // Filter status
        if ($request->has('filter_status') || ($request->filter_status_condition == "nullable" || $request->filter_status_condition == "notNullable")) {
            $relation = "status";
            $column = "id";
            $value = $request->filter_status;
            $condition = null;
            if ($request->has('filter_status_condition')) {
                $condition = $request->filter_status_condition;
            }
            $orders = $orders->FilterRelationIntHas($relation, $column, $condition, $value);
        }
//
//        // Filter from address
        if ($request->has('filter_from_address') || ($request->filter_from_address_condition == "nullable" || $request->filter_from_address_condition == "notNullable")) {
            $column = "JSON_UNQUOTE(JSON_EXTRACT(address, '$.title'))";
            $value = $request->filter_from_address;
            $condition = null;
            if ($request->has('filter_from_address_condition')) {
                $condition = $request->filter_from_address_condition;
            }
            $orders = $orders->FilterString($column, $condition, $value);
        }
//
//        // Filter to addresses
        if ($request->has('filter_to_addresses') || ($request->filter_to_addresses_condition == "nullable" || $request->filter_to_addresses_condition == "notNullable")) {
            $relation = "to_addresses";
            $column = "JSON_UNQUOTE(JSON_EXTRACT(address, '$.title'))";
            $value = $request->filter_to_addresses;
            $condition = null;
            if ($request->has('filter_to_addresses_condition')) {
                $condition = $request->filter_to_addresses_condition;
            }
            $orders = $orders->FilterRelationStringHas($relation, $column, $condition, $value);
        }
//        // Filter payment type
//        if($request->has('filter_payment_type')) {
//            $filters = PerformerCardType::query();
//            $column = 'name';
//            $value = $request->filter_payment_type;
//            $condition = null;
//            if ($request->has('filter_payment_type_condition')) {
//                $condition = $request->filter_payment_type_condition;
//            }
//            $filters = $filters->FilterString($column, $condition, $value);
//            $ids = $filters->pluck('id');
//            $card_ids = ClientCard::whereIn('card_type_id',$ids)->pluck('id');
//            $payTypes = ClientPayType::whereIn('card_type_id',$ids)->pluck('id');
//            $clientpaytypes = ClientPayType::whereIn('model_id',$card_ids)->pluck('id');
//            $payType_ids = array_merge($payTypes->toArray(),$clientpaytypes->toArray());
//            $orders = $orders->whereIn('pay_type_id', $payType_ids);
//        }
//
//
//        // Filter status id
        if ($request->has('filter_status_id') || ($request->filter_status_id_condition == "nullable" || $request->filter_status_id_condition == "notNullable")) {
            $column = "status_id";
            $value = $request->filter_status_id;
            $condition = null;
            if ($request->has('filter_status_id_condition')) {
                $condition = $request->filter_status_id_condition;
            }
            $orders = $orders->FilterInt($column, $condition, $value);
        }
//
//        // Filter tariff id
        if ($request->has('filter_tariff_id') || ($request->filter_tariff_id_condition == "nullable" || $request->filter_tariff_id_condition == "notNullable")) {
            $column = "tariff_id";
            $value = $request->filter_tariff_id;
            $condition = null;
            if ($request->has('filter_tariff_id_condition')) {
                $condition = $request->filter_tariff_id_condition;
            }
            $orders = $orders->FilterInt($column, $condition, $value);
        }
//
//        // Filter order type id
        if ($request->has('filter_order_type_id') || ($request->filter_order_type_id_condition == "nullable" || $request->filter_order_type_id_condition == "notNullable")) {
            $column = "orders.order_type_id";
            $value = $request->filter_order_type_id;
            $condition = null;
            if ($request->has('filter_order_type_id_condition')) {
                $condition = $request->filter_order_type_id_condition;
            }
            $orders = $orders->FilterInt($column, $condition, $value);
        }

//        // Filter created at
        if ($request->has('filter_from_created_at')) {
            $orders = $orders->where('created_at', '>=', Carbon::parse($request->filter_from_created_at)->format('Y-m-d'));
        }

        if ($request->has('filter_to_created_at')) {
            $orders = $orders->where('created_at', '<=', Carbon::parse($request->filter_to_created_at)->format('Y-m-d'));
        }

        // Filter date_time
        if ($request->has('filter_from_date_time')) {
            $orders = $orders->where('date_time', '>=', Carbon::parse($request->filter_from_date_time)->format('Y-m-d'));
        }

        if ($request->has('filter_to_date_time')) {
            $orders = $orders->where('date_time', '<=', Carbon::parse($request->filter_to_date_time)->format('Y-m-d'));
        }
//
//        // Filter from created_at
        // if ($request->has('filter_from_created_at')) {
        //     $column = "created_at";
        //     $from_created_at = $request->filter_from_created_at;
        //     $carbonDate = Carbon::createFromFormat('d-m-Y H:i', $from_created_at)->format('Y-m-d H:i:s');
        //     $condition = null;
        //     if ($request->has('filter_from_created_at_condition')) {
        //         $condition = $request->filter_from_created_at_condition;
        //     }
        //     $orders = $orders->FilterString($column, $condition, $carbonDate);
        // }
//
//        // // Filter to created_at
//         if ($request->has('filter_to_created_at')) {
//             $column = "created_at";
//             $to_created_at = $request->filter_to_created_at;
//             $carbonDate = Carbon::createFromFormat('d-m-Y H:i', $to_created_at)->format('Y-m-d H:i:s');
//             $condition = null;
//             if ($request->has('filter_to_created_at_condition')) {
//                 $condition = $request->filter_to_created_at_condition;
//             }
//             $orders = $orders->FilterString($column, $condition, $carbonDate);
//         }

        // Filter division id
        if ($request->has('filter_division_id') || ($request->filter_division_id_condition == "nullable" || $request->filter_division_id_condition == "notNullable")) {
            $relation = "division";
            $column = "id";
            $value = $request->filter_division_id;
            $condition = null;
            if ($request->has('filter_division_id_condition')) {
                $condition = $request->filter_division_id_condition;
            }
            $orders = $orders->FilterRelationIntHas($relation, $column, $condition, $value);
        }

        // Filter auto_assignment
        if ($request->has('filter_auto_assignment') || ($request->filter_auto_assignment_condition == "nullable" || $request->filter_auto_assignment_condition == "notNullable")) {
            $column = "auto_assignment";
            $value = $request->filter_auto_assignment;
            $condition = null;
            if ($request->has('filter_auto_assignment_condition')) {
                $condition = $request->filter_auto_assignment_condition;
            }
            $orders = $orders->FilterString($column, $condition, $value);
        }

        //        // Filter not_issued
        if ($request->has('filter_not_issued') || ($request->filter_not_issued_condition == "nullable" || $request->filter_not_issued_condition == "notNullable")) {
            $column = "not_issued";
            $value = $request->filter_not_issued;
            $condition = null;
            if ($request->has('filter_not_issued_condition')) {
                $condition = $request->filter_not_issued_condition;
            }
            $orders = $orders->FilterInt($column, $condition, $value);
        }

        //        // Filter for_time
        if ($request->has('filter_for_time') || ($request->filter_for_time_condition == "nullable" || $request->filter_for_time_condition == "notNullable")) {
            $column = "for_time";
            $value = $request->filter_for_time;
            $condition = null;
            if ($request->has('filter_for_time_condition')) {
                $condition = $request->filter_for_time_condition;
            }
            $orders = $orders->FilterInt($column, $condition, $value);
        }

//
//        // filter full name performer
//        if ($request->has('filter_full_name') || ($request->filter_full_name_condition == "nullable" || $request->filter_full_name_condition == "notNullable")) {
//            $relation = 'performer.driver';
//            $column = "CONCAT(last_name,' ',first_name,IF(patronymic IS NULL,'', CONCAT(' ',patronymic)))";
//            $value = $request->filter_full_name;
//            $condition = null;
//            if ($request->has('filter_full_name_condition')) {
//                $condition = $request->filter_full_name_condition;
//            }
//            $orders = $orders->FilterRelationStringHas($relation,$column, $condition, $value);
//        }
//
//        // filter full car info
//        if($request->has('filter_car_info')) {
//            $filter_car_info = (string)$request->filter_car_info;
//            $performer_transport = PerformerTransport::query()->select('performer_transports.performer_id',
//                DB::raw("CONCAT(m.name,' ',c.name,' ', LEFT(car_number,4)) AS car_info"))
//                ->join('model_cars as m', 'performer_transports.car_model_id', 'm.id')
//                ->join('colors as c', 'performer_transports.color_id', 'c.id');
//            if($request->has('filter_car_info_condition')) {
//                $filter_car_info_condition = $request->filter_car_info_condition;
//                if($filter_car_info_condition == "startLike") {
//                    $performer_transport->having('car_info', 'LIKE', $filter_car_info.'%');
//                }elseif($filter_car_info_condition == "endLike") {
//                    $performer_transport->having('car_info', 'LIKE', '%'.$filter_car_info);
//                }elseif($filter_car_info_condition == "include") {
//                    $performer_transport->having('car_info', 'LIKE', '%'.$filter_car_info.'%');
//                }elseif($filter_car_info_condition == "not_include") {
//                    $performer_transport->having('car_info', 'NOT LIKE', '%'.$filter_car_info.'%');
//                }
//            }else{
//                $performer_transport->having('car_info', '=', $filter_car_info);
//            }
//            $performer_ids = $performer_transport->get()->pluck('performer_id')->toArray();
//            $order_ids = PerformerOrder::whereIn('performer_id', $performer_ids)->get()->pluck('order_id')->toArray();
//            $orders->whereIn('id', $order_ids);
//        }
//
//        // filter info for operator
//        if($request->has('filter_info_for_operator') || ($request->filter_info_for_operator_condition == "nullable" || $request->filter_info_for_operator_condition == "notNullable")){
//            $column = "supervisor_comment";
//            $value = $request->filter_info_for_operator;
//            $condition = null;
//            if ($request->has('filter_info_for_operator_condition')){
//                $condition = $request->filter_info_for_operator_condition;
//            }
//            $orders = $orders->FilterString($column, $condition, $value);
//        }
//
//        // filter info for drivers
        if ($request->has('filter_info_for_drivers') || ($request->filter_info_for_drivers_condition == "nullable" || $request->filter_info_for_drivers_condition == "notNullable")) {
            $column = "comment";
            $value = $request->filter_info_for_drivers;
            $condition = null;
            if ($request->has('filter_info_for_drivers_condition')) {
                $condition = $request->filter_info_for_drivers_condition;
            }
            $orders = $orders->FilterString($column, $condition, $value);
        }
//
//        // Filter client status
        if ($request->has('filter_client_status')) {
            $status = 0;
            if ($request->filter_client_status === "ANSWERED") {
                $status = 1;
            }
            $orders = $orders->where('client_status', '=', $status);
        }
//
//        // Filter distance
        if ($request->has('filter_distance') || ($request->filter_distance_condition == "nullable" || $request->filter_distance_condition == "notNullable")) {
            $column = "orders.distance";
            $value = $request->filter_distance;
            $condition = null;
            if ($request->has('filter_distance_condition')) {
                $condition = $request->filter_distance_condition;
            }
            $orders = $orders->FilterString($column, $condition, $value);
        }
//
//        // Filter commission
        if ($request->has('filter_commission_price') || ($request->filter_commission_price_condition == "nullable" || $request->filter_commission_price_condition == "notNullable")) {
            $column = "orders.price_commission";
            $value = $request->filter_commission_price;
            $condition = null;
            if ($request->has('filter_commission_price_condition')) {
                $condition = $request->filter_commission_price_condition;
            }
            $orders = $orders->FilterString($column, $condition, $value);
        }
//
//        // Filter price
        if ($request->has('filter_price') || ($request->filter_price_condition == "nullable" || $request->filter_price_condition == "notNullable")) {
            $column = "orders.price";
            $value = $request->filter_price;
            $condition = null;
            if ($request->has('filter_price_condition')) {
                $condition = $request->filter_price_condition;
            }
            $orders = $orders->FilterString($column, $condition, $value);
        }
//
//         // Filter performer login
//         if($request->has('filter_performer_login') || ($request->filter_performer_login_condition == "nullable" || $request->filter_performer_login_condition == "notNullable")){
//            $relation = 'performer.driver';
//            $column = "login";
//            $value = $request->filter_performer_login;
//            $condition = null;
//            if ($request->has('filter_performer_login_condition')){
//                $condition = $request->filter_performer_login_condition;
//            }
//            $orders = $orders->FilterRelationStringHas($relation, $column, $condition, $value);
//        }
//
//         if (count($request->all()) < 1) {
//             if (auth()->user()->getRoleNames()[0] == Order::OPERATOR) {
//                 $orders = $orders->where('create_user_id', auth()->id());
//             }
//         }

        $orders = $orders->orderByDesc('id')->limit($limit)->get();
//        return $this->gzipJson(JournalOrderResource::collection($orders));
        return response()->json(JournalOrderResource::collection($orders));
    }
}
