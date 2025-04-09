<?php

namespace App\Http\Resources;

use App\Models\Histories\OrderHistory;
use App\Models\Order;
use App\Models\OrderCommission;
use App\Models\PriceTariff;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class JournalOrderResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Http\Resources\Json\JsonResource
     */

    public function toArray($request)
    {

        // $order_history = $this->order_history_assigment;
        // if ($order_history && $this->performer) {
        //     $assigned_by_login = $order_history->model;
        //     if ($order_history->model == 'admin') {
        //         $assigned_by_login = $order_history->user_editor->login;
        //     }
        // } else {
        //     $assigned_by_login = null;
        // }

        return [
            "id" => $this->id,
            "division_id" => $this->division_id,
            "division" => $this?->division?->name,
            'phone' => $this?->client?->phone,
            'dop_phone' => $this->dop_phone,
            'auto_assignment' => $this->auto_assignment,
            'not_issued' => $this->not_issued,
            'for_time' => $this->for_time,
            'date_time' => $date_time ?? null,
            'distance' => $this->distance ?? null,
            'distance_in_city' => $this->distance_in_city ?? null,
            'search_address_id' => $this->search_address_id ?? null,
            'from_address' => $this->parseAddress($this->address),
            'to_addresses' => array_filter(OrderToAddressResuorce::collection($this->to_addresses)->toArray($this->to_addresses),function($value) {
                return !is_null($value);
            }),
            'meeting_info' => $this->meeting_info ?? null,
            'info_for_operator' => $this->supervisor_comment ?? null,
            'info_for_drivers' => $this->comment ?? null,
            'order_type_id' => $this->order_type_id ?? null,
            'type' => $this->type->name ?? null,
            'tariff_id' => $this->tariff_id ?? null,
            'tariff' => isset($this->tariff->name) ? $this->tariff->name : null,

            'number_of_passengers' => $this->number_of_passengers ?? null,
            'status_id' => $this->status_id ?? null,
            'status' => $this->status->name ?? null,
            'client_status' => $this->client_status,
            'active_bonus' => $this->active_bonus,
            'bonus_price' => $this->bonus_price,
            'price_cash' => $this->price - $this->bonus_price,
            'price' => $this->price ?? null ,
            'price_by_performer' => $this->tariff->prices->price_by_performers + $this->price,
            'price_by_performers' => $this->tariff->prices->price_by_performers ?? null,
            'price_in_city' => $this->price_in_city ?? null,
            'price_inter_city' => $this->price_inter_city ?? null,
            'free_km' => $this->free_km ?? null,
            'geo_json_array' => $this->geo_json_array ?? null,
            'commission_price' => (string)$this->price_commission == '0' ? (OrderCommission::first('percent')?->percent ?? config('order.commission')) * $this->price : $this->price_commission,
            //'info_price' => $this->info_price,
            'reason_cancel_order' => $this?->reasonCancel?->reason_cancel_order,
            'allowances' => OrderAllowancesResource::collection($this->order_allowances),
            'performer' => new OrderPerformerResource($this->performer),
            'create_user' => $this->when($this->users, function() {
                return new UserOrderResource($this->users);
            }, function() {
                return [
                    "id" => 0,
                    "login" => "stu_ClientCabinet"
                ];
            }),
            'filing_time' => isset($this->performer->filing_time) ? Carbon::parse($this->performer->filing_time)->format('Y-m-d H:i:s') : null,
            'start_time' => !is_null($this?->performer_order?->start_filing_time)?Carbon::parse($this->performer_order->start_filing_time)->toDateTimeString():null,
            'created_at' => isset($this->created_at) ? Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
            'updated_at' => isset($this->updated_at) ? Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null,
            'end_time' => isset($this->end_time) ? Carbon::parse($this->end_time)->format('Y-m-d H:i:s') : null,
            'past_minute' => 0,
            'payment_type_id' => $this->pay_type_id,
            'payment_type' => isset($this->payment_type($this->payType)['text'])?$this->payment_type($this->payType)['text']:null,
            'assignmentBy' => $this->assign_by_login
        ];
    }

    private function payment_type($relation)
    {
        if($relation) {
            return ClientPayTypeResource::make($relation)->toArray($relation);
        }
        return [
            'id' => 0,
            'type' => 'Cash',
            'card_id' => "",
            'card_number' => "",
            'text' => "Наличными",
            'icon' => "",
            'sort' => 0,
            'status' => 1
        ];
    }

    private function parseAddress($address)
    {
        $address = json_decode($address,true);
        $result = null;
        if(isset($address['lng']) && isset($address['lat'])) {
            if(!isset($address['body']) || $address['body'] == "")  {
                $address['body'] = "";
            }
            if(!isset($address['address']) || $address['address'] == "")  {
                $address['address'] = "";
            }
            $title = '';
            if(isset($address['title']) && $address['title'] != "")  {
                $title = $address['title'];
            }

            if(isset($address['name'])) {
                $title = $address['name'];
                if(isset($address['type']) && $address['type'] == 'address') {
                    $title = $address['street_type'].' '.$address['street'].', '.$address['name'];
                }
            }

            $address['title'] = $title;
            $result = [
                'id' => $address['id'],
                'address' => $address['address'],
                'title' => $address['title'],
                'body' => $address['body'],
                'lng' => (float)$address['lng'],
                'lat' => (float)$address['lat']
            ];
            $title_point = [];
            $pointSlug = \Str::slug($result['title'],'_');
            $is_point = str_starts_with($pointSlug,'metka');
            if($result['id'] == 0 && $is_point) {
                $title_point[0] = 'Метка на карте';
                if(!empty($result['address'])) {
                    array_push($title_point,$result['address']);
                }
                $result['title'] = implode(', ',$title_point);
            }
        }
        return $result;
    }
}
