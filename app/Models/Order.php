<?php

namespace App\Models;

use App\Models\Histories\OrderHistory;
use App\Models\Report\OrderStatusTime;
use App\Traits\FiltersTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Order extends BasicModel
{
    use HasFactory;
    use FiltersTrait;

    protected $connection = 'pgsql';
    const AUTO = 1;
    const NO_AUTO = 0;
    const ORDER_NEW = [Order::RECEVIED,Order::NOT_ISSUED];
    const PREV_ASSIGNMENT = 3;
    const ACTIVE_STATUSES = [2,4,7];
    const CANCELLATION = 10;
    const COMPLETE = 9;
    const DRIVER_ASSINGMENT = 2;
    const RECEVIED = 1;
    const ORDER_END_TIME_ADD = 15;
    const ASSIGNMENT = 2;
    const DRIVER_ON_SITE = 4;
    const PERFORMING = 7;
    const NOT_ISSUED = 11;
    const HOVER_24_COMPLETE = 14;
    const CLIENT_ANSWERED = 5;
    const CLIENT_NO_ANSWER = 6;
    const OPERATOR_ID = 2;
    const OPERATOR = 'operator';
    const MANAGER_ID = 3;
    const CLIENT_ALERTED = 1;
    const CLIENT_NOT_ALERTED = 2;
    protected $fillable = [
        'client_id',
        'create_user_id',
        'division_id',
        'dop_phone',
        'auto_assignment',
        'not_issued',
        'for_time',
        'price_percent',
        'date_time',
        'search_address_id',
        'distance',
        'meeting_info',
        'comment',
        'active_bonus',
        'bonus_price',
        'supervisor_comment',
        'tariff_id',
        'status_id',
        'order_type_id',
        'price',
        'info_price',
        'price_tariff_id',
        'price_commission',
        'order_commission_id',
        'number_of_passengers',
        'end_time',
        'active_bonus',
        'bonus_price',
        'distance_in_city',
        'price_in_city',
        'price_inter_city',
        'free_km',
        'allowance_price',
        'allowance_percents_price',
        'bonus_price',
        'address',
        'geo_json_array',
        'assign_by_login'
    ];

    public function tariffPrices()
    {
        return $this->belongsTo(PriceTariff::class, 'price_tariff_id', 'id');
    }

    public function requestPerformers() {
        return $this->hasMany(RequestPerformerToOrder::class, 'order_id', 'id');
    }

    public function order_commission()
    {
        return $this->belongsTo(OrderCommission::class, 'order_commission_id', 'id')->withTrashed();
    }




    public function order_allowances()
    {
        return $this->hasMany(OrderAllowance::class, 'order_id', 'id')->with(['allowance']);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class, 'tariff_id', 'id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(OrderType::class, 'order_type_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id', 'id');
    }

    public function performer()
    {
        return $this->hasOne(PerformerOrder::class, 'order_id', 'id')->with('driver');
    }

    public function performer_order()
    {
        return $this->hasOne(PerformerOrder::class, 'order_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'create_user_id', 'id');
    }
    public function  allowances() {
        return $this->hasMany(OrderAllowance::class, 'order_id', 'id')->with('allowance');
    }

    public function wait()
    {
        return $this->hasOne(PerformerWaiting::class,'order_id','id')->whereNotNull('start_time')->whereNull('end_time')->latest();
    }

    public function grade()
    {
        return $this->hasOne(PerformerActivity::class,'order_id','id')->latest()->with('type')->whereHas('type', function($query) {
            $query->where('code', PerformerActivityType::COMPLATE_ORDER);
        });
    }

    public function gradeNegative()
    {
        return $this->hasOne(PerformerActivity::class,'order_id','id')->whereHas('type', function($query) {
            $query->where('code', PerformerActivityType::ROLLBACK_ORDER);
        });
    }

    public function payType()
    {
        return $this->belongsTo(ClientPayType::class,'pay_type_id','id');
    }

}
