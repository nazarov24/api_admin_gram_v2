<?php

namespace App\Models;

use App\Models\Car\ClassCar;
use App\Models\Histories\Performer\PerformerTransportHistory;
use App\Traits\FiltersTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformerTransport extends BasicModel
{
    
    use SoftDeletes;
    
    protected $connection = 'pgsql';
    public $table = 'public.performer_transports';
    public const ACTIVE_CONNECTION = 1;
    public const WAITING_CONNECTION = 2;
    public const DELETED = 3;
    public const ACTIVE = 1;
    public const DISABLED = 0;

    public const CARGO = 3;

    protected $fillable = [
        'division_id',
        'performer_id',
        'car_model_id',
        'body_type_id',
        'condition_id',
        'color_id',
        'dop_info',
        'year_of_issue',
        'count_seat',
        'car_number',
        'connected_id',
        'active',
        'fuel_type_id'
    ];

    public function division(){
        return $this->belongsTo(Division::class,'division_id', 'id');
    }
    public function model_car() {
        return $this->belongsTo(Marka::class, 'car_model_id', 'id');
    }
    public function body_type() {
        return $this->belongsTo(BodyType::class, 'body_type_id', 'id');
    }
    
    public function condition() {
        return $this->belongsTo(CarCondition::class, 'condition_id', 'id');
    }
    public function car_connection() {
        return $this->belongsTo(CarConnected::class, 'connected_id', 'id');
    }
    public function car_drivers() {
        return $this->belongsToMany(Performer::class, DriverCar::class, 'car_id', 'driver_id');
    }

    public function performer_info()
    {
        return $this->belongsTo(Performer::class, 'performer_id', 'id');
    }

   
    public function  created_user() {
        return $this->belongsTo(User::class,'created_user_id', 'id');
    }
    public function  updated_user() {
        return $this->belongsTo(User::class,'updated_user_id', 'id');
    }

    public function car_options() {
        return $this->hasMany(PerformerTransportOption::class, 'performer_transport_id', 'id');
    }

    public function dopOptions() {
        return $this->hasMany(PerformerTransportOption::class, 'performer_transport_id', 'id')->whereHas('car_option', function($query) {
            $query->whereNull('model');
        })->whereNotNull('option_id')->groupBy('option_id');
    }

    public function fuel_type()
    {
        return $this->belongsTo(CarOption::class, 'fuel_type_id','id');
    }
}
