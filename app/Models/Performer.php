<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Performer extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'public.performers';

    const COLLECTIONNAME = "photo_control";
    const CITY_ID = 2;
    const PHOTO_CONTROL_STATUS = [
        'ACCEPTED',
        'IN_PROCESS',
        'NOT_ACCEPTED',
        'ASSIGNE'
    ];
    const ACTIVE = 1;
    const BONUS_COMMISSION_AFTER_REGISTER = ['percent' => 0,'expire_months' => 1];
    const DISABLE = 0;
    const FREE = 1;
    const NOT_FREE = 0;
    const TYPE_EARNING_ID = 2;
    protected static $logFillable = true;
    protected $fillable = [
        'user_id',
        'division_id',  
        'promo_code',
        'city_id',
        'rating',
        'expired_zero_commission',
        'commission_percent',
        'type_earning_id',
        'serials_number',
        'expirated_driver_license',
        'serial_number_passport',
        'expirated_passport',
        'district_id',
        'passport_office_id',
        'passport_serials',
        'address',
        'is_active',
        'status',
        'phone',
        'phone_without_code',
        'password',
        'login',
        'is_free',
        'fcm_token',
        'created_by',
        'is_online',
        'socket_id',
        'rating_by_client',
        'is_on_shift',
        'photo_control_status'
    ];

    protected $hidden = [
        'password',
        'city_id',
        'type_movement_id',
        'phone_without_code',
        'promo_code',
        'parent_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }    

    public function performer_transports()
    {
        return $this->hasMany(PerformerTransport::class,'performer_id','id');
    }
    public function division()
    {
        return $this->belongsTo(Division::class,'division_id','id');
    }

    public function active_car() {
        return $this->hasOne(PerformerTransport::class,'performer_id','id');
    }

    public function active_order() {
        return $this->hasOne(PerformerOrder::class,'performer_id','id');
    }

    public function driver_cars() {
        return $this->belongsToMany(PerformerTransport::class, DriverCar::class, 'driver_id', 'car_id');
    }

    public function car() {
        return $this->belongsToMany(PerformerTransport::class, DriverCar::class, 'driver_id', 'car_id')->where('active',1);
    }

    public function transport() {
        return $this->belongsToMany(PerformerTransport::class, DriverCar::class, 'driver_id', 'car_id')->where('active', self::ACTIVE);
    }

    public function car_info() {
        return $this->hasOne(PerformerTransport::class, 'performer_id', 'id')
                        ->where('active', PerformerTransport::ACTIVE)
                        ->where('connected_id', PerformerTransport::ACTIVE_CONNECTION);
    }

    
    public function performer_location(){
        return $this->belongsTo(PerformerLocation::class, 'id' , 'performer_id')->with(['district']);
    }

  
    public function district(){
        return $this->belongsTo(District::class, 'district_id', 'id');
    }


    public function performer_tariffs()
    {
        return $this->hasMany(PerformerTariff::class, 'performer_id', 'id')->with('tariff');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, PerformerOrder::class);
    }

    public function car_state()
    {
        return $this->hasOne(CarState::class,'performer_id','id')->latest();
    }

    public function track()
    {
        return $this->hasOne(DriverTracking::class, 'performer_id', 'id')->whereNotNull('lng')->whereNotNull('lat')->latestOfMany();
    }

    public function currentOrder()
    {
        return $this->hasOne(PerformerOrder::class, 'performer_id', 'id')->orderByDesc('id');
    }

}
