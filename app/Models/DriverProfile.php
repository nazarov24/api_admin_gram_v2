<?php

namespace App\Models;

use App\Traits\FiltersTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DriverProfile extends Model
{
    use HasFactory;
    public const NEW = 1;
    public const DRIVER_ACCEPTED = 2;
    public const DRIVER_INVITED = 3;
    public const REFUSE = 4;
    public const NO_CALLED = 5;
    public const NOT_REACH = 6;
    public const FOR_REVISION = 7;

    protected $connection = 'pgsql';
    protected $table = "public.driver_profiles";
   
    protected $fillable = [
        'id',
        'division_id',
        'first_name',
        'last_name',
        'patronymic',
        'driver_profile_type_id',
        'driver_profile_status_id',
        'from_time',
        'before_time',
        'phone',
        'comment',
        'cause_id',
        'user_id',
        'email',
        'gender',
        'date_of_birth',
        'promo_code',
        'type_earning_id',
        'serials_number',
        'expirated_driver_license',
        'serial_number_passport',
        'expirated_passport',
        'driver_license_type_id',
        'passport_office_id',
        'address',
        'district_id',
        'reminder_date_at',
        'reminder_user_id',
        'created_at'
    ];

    public function division()
    {
    	return $this->belongsTo(Division::class, 'division_id', 'id');
    }
    public function status()
    {
        return $this->belongsTo(DriverProfileStatus::class, 'driver_profile_status_id', 'id');
    }
    public function type()
    {
        return $this->belongsTo(DriverProfileType::class, 'driver_profile_type_id', 'id');
    }
    public function car()
    {
        return $this->belongsTo(DriverProfileCar::class, 'id', 'driver_profile_id');
    }
    public function cause()
    {
        return $this->belongsTo(DriverProfileCause::class, 'cause_id', 'id');
    }
    public function district() {
        return $this->belongsTo(District::class, 'district_id','id');
    }
   
    public function driver_license_type() {
        return $this->belongsTo(DriverLicenseType::class, 'driver_license_type_id','id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function reminder_user() {
        return $this->belongsTo(User::class, 'reminder_user_id', 'id');
    }
}
