<?php

namespace App\Services\Order;

use App\Http\Resources\JournalOrderResource;
use App\Models\PerformerTransport;
use App\Models\PushNotifyList;
use App\Models\StateStatus;
use App\Services\FilterService;
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
            'client:id,device',
            'division:id',
            'type:id,name',
            'tariff:id',
            'users:id',
            'tariffPrices'
        ]);

        $strint = [
            'id' => ['type' => 'integer'],
            'client_id' => ['type' => 'integer', 'relation' => 'client', 'column' => 'id'],
            'division_id' => ['type' => 'integer', 'relation' => 'division', 'column' => 'id'],
            'dop_phone' => ['type' => 'string'],
            'distance' => ['type' => 'integer'],
            'auto_assignment' => ['type' => 'boolean'],
            'not_issued' => ['type' => 'boolean'],
            'for_time' => ['type' => 'string'],
            'date_time' => ['type' => 'range'],
            'number_of_passengers' => ['type' => 'integer'],
            'search_address_id' => ['type' => 'integer', 'relation' => 'search_address', 'column' => 'id'],
            'meeting_info' => ['type' => 'string'],
            'comment' => ['type' => 'string'],
            'supervisor_comment' => ['type' => 'string'],
            'order_type_id' => ['type' => 'integer'],
            'tariff_id' => ['type' => 'integer'],
            'status_id' => ['type' => 'integer', 'relation' => 'status', 'column' => 'id'],
            'create_user_id' => ['type' => 'relation', 'column' => 'id'],
            'price' => ['type' => 'integer'],
            'info_price' => ['type' => 'integer'],
            'created_at' => ['type' => 'range'],
            'updated_at' => ['type' => 'range'],
            'completed_at' => ['type' => 'range'],
            'end_time' => ['type' => 'string'],
            'price_tariff_id' => ['type' => 'string', 'relation' => 'price_tariff', 'column' => 'tariff'],
            'realtime_key' => ['type' => 'string'],
            'reason_cancel_order' => ['type' => 'string'],
            'client_status' => ['type' => 'integer'],
            'end_free_wait_time' => ['type' => 'integer'],
            'order_commission_id' => ['type' => 'integer'],
            'distance_in_city' => ['type' => 'integer'],
            'price_in_city' => ['type' => 'integer'],
            'price_inter_city' => ['type' => 'integer'],
            'geo_json_array' => ['type' => 'string'],
            'free_km' => ['type' => 'integer'],
            'bonus_price' => ['type' => 'integer'],
            'active_bonus' => ['type' => 'boolean'],
            'price_commission' => ['type' => 'integer'],
            'processing_at' => ['type' => 'string'],
            'allowance_percents_price' => ['type' => 'integer'],
            'allowance_price' => ['type' => 'integer'],
            'start_free_wait_time' => ['type' => 'integer'],
            'assign_by_login' => ['type' => 'string'],
            'pay_type_id' => ['type' => 'integer'],
            'price_percent' => ['type' => 'integer'],
            'address' => ['type' => 'string'],
            'tariff_prices' => ['type' => 'integer', 'column' => 'tariffPrices'],
        ];
        $orders = (new \App\Services\FilterService)->applyFilters($orders, $request, $strint);

        $orders = $orders->orderByDesc('id')->limit($limit)->get();

        return response()->json(JournalOrderResource::collection($orders));

    }
}
