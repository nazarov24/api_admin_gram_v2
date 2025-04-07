<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverCar extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'public.driver_cars';
    
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'car_id'
    ];

    public function driver(){
        return $this->belongsTo(Performer::class,'driver_id', 'id');
    }
    public function car() {
        return $this->belongsTo(PerformerTransport::class, 'car_id', 'id');
    }
}
