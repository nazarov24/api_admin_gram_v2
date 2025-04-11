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


            'id' => $this->id,
            'client_id' => $this->client_id,
            'division_id' => $this->division_id,
            'dop_phone' => $this->dop_phone,
            'distance' => $this->distance,
            'auto_assignment' => $this->auto_assignment,
            'not_issued' => $this->not_issued,
            'for_time' => $this->for_time,
            'date_time' => $this->date_time,
            'number_of_passengers' => $this->number_of_passengers,
            'search_address_id' => $this->search_address_id,
            'meeting_info' => $this->meeting_info,
            'comment' => $this->comment,
            'supervisor_comment' => $this->supervisor_comment,
            'order_type_id' => $this->order_type_id,
            'tariff_id' => $this->tariff_id,
            'status_id' => $this->status_id,
            'create_user_id' => $this->create_user_id,
            'price' => $this->price,
            'info_price' => $this->info_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'completed_at' => $this->completed_at,
            'end_time' => $this->end_time,
            'price_tariff_id' => $this->price_tariff_id,
            'realtime_key' => $this->realtime_key,
            'reason_cancel_order' => $this->reason_cancel_order,
            'client_status' => $this->client_status,
            'end_free_wait_time' => $this->end_free_wait_time,
            'order_commission_id' => $this->order_commission_id,
            'distance_in_city' => $this->distance_in_city,
            'price_in_city' => $this->price_in_city,
            'price_inter_city' => $this->price_inter_city,
            'geo_json_array' => $this->geo_json_array,
            'free_km' => $this->free_km,
            'bonus_price' => $this->bonus_price,
            'active_bonus' => $this->active_bonus,
            'price_commission' => $this->price_commission,
            'processing_at' => $this->processing_at,
            'allowance_percents_price' => $this->allowance_percents_price,
            'allowance_price' => $this->allowance_price,
            'start_free_wait_time' => $this->start_free_wait_time,
            'assign_by_login' => $this->assign_by_login,
            'pay_type_id' => $this->pay_type_id,
            'price_percent' => $this->price_percent,
            'address' => json_encode($this->address),
            'tariff_prices' => $this->tariff_prices,
//            'client' => new ClientResource($this->client),  // Assuming a relationship exists
//            'division' => new DivisionResource($this->division),  // Assuming a relationship exists
//            'type' => new TypeResource($this->type),  // Assuming a relationship exists
//            'tariff' => new TariffResource($this->tariff),  // Assuming a relationship exists
//            'users' => new UserResource($this->users),  // Assuming a relationship exists
        ];
    }

//    private function payment_type($relation)
//    {
//        if($relation) {
//            return ClientPayTypeResource::make($relation)->toArray($relation);
//        }
//        return [
//            'id' => 0,
//            'type' => 'Cash',
//            'card_id' => "",
//            'card_number' => "",
//            'text' => "Наличными",
//            'icon' => "",
//            'sort' => 0,
//            'status' => 1
//        ];
//    }
//
//    private function parseAddress($address)
//    {
//        $address = json_decode($address,true);
//        $result = null;
//        if(isset($address['lng']) && isset($address['lat'])) {
//            if(!isset($address['body']) || $address['body'] == "")  {
//                $address['body'] = "";
//            }
//            if(!isset($address['address']) || $address['address'] == "")  {
//                $address['address'] = "";
//            }
//            $title = '';
//            if(isset($address['title']) && $address['title'] != "")  {
//                $title = $address['title'];
//            }
//
//            if(isset($address['name'])) {
//                $title = $address['name'];
//                if(isset($address['type']) && $address['type'] == 'address') {
//                    $title = $address['street_type'].' '.$address['street'].', '.$address['name'];
//                }
//            }
//
//            $address['title'] = $title;
//            $result = [
//                'id' => $address['id'],
//                'address' => $address['address'],
//                'title' => $address['title'],
//                'body' => $address['body'],
//                'lng' => (float)$address['lng'],
//                'lat' => (float)$address['lat']
//            ];
//            $title_point = [];
//            $pointSlug = \Str::slug($result['title'],'_');
//            $is_point = str_starts_with($pointSlug,'metka');
//            if($result['id'] == 0 && $is_point) {
//                $title_point[0] = 'Метка на карте';
//                if(!empty($result['address'])) {
//                    array_push($title_point,$result['address']);
//                }
//                $result['title'] = implode(', ',$title_point);
//            }
//        }
//        return $result;
//    }
}
