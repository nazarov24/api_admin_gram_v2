<?php

namespace App\Http\Resources\DriverProfile;

use App\Http\Resources\User\CreatedUserResource;
use App\Models\District;
use App\Models\Division;
use App\Models\DriverLicenseType;
use App\Models\DriverProfile;
use App\Models\DriverProfileCar;
use App\Models\DriverProfileCause;
use App\Models\DriverProfileStatus;
use App\Models\DriverProfileType;
use App\Models\PassportOffice;
use App\Models\PerformerTransport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Psy\Command\WhereamiCommand;

class DriverProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $color = 'white';
        if($this->created_at >= Carbon::now()->subHour() && $this->driver_profile_status_id == DriverProfile::NEW)
        {
            $color = 'green';
        }elseif($this->created_at <= Carbon::now()->subHour() && $this->driver_profile_status_id == DriverProfile::NEW){
            $color = 'yellow';
        }elseif($this->reminder_date_at <= Carbon::now() && $this->driver_profile_status_id == DriverProfile::NEW){
            $color = 'red';
        }elseif($this->driver_profile_status_id == DriverProfile::FOR_REVISION && !is_null($this->reminder_date_at))
        {
            $color = 'blue';
        }
        return [
            'id' => $this->id,
            'division_id' => $this->division_id,
            'division' => $this->whenPivotLoadedAs('division', Division::class, function () {
                return $this->division->name;
            }),
            'full_name' => $this->full_name,
            'first_name' => $this->when($this->first_name!=null,function(){return $this->first_name;}),
            'last_name' => $this->when($this->last_name!=null,function(){return $this->last_name;}),
            'patronymic' => $this->when($this->patronymic!=null,function(){return $this->patronymic;}),
            'phone' => $this->phone,
            'dop_phone' => $this->when($this->dop_phone!=null,function(){return $this->dop_phone;}),
            'from_time' => $this->when($this->from_time!=null,function(){return Carbon::parse($this->from_time)->format('H:i');}),
            'before_time' => $this->when($this->before_time!=null,function(){return Carbon::parse($this->before_time)->format('H:i');}),
            'status_id' => $this->driver_profile_status_id,
            'status' => $this->whenPivotLoadedAs('status', DriverProfileStatus::class, function() {
                return $this->status->name;
            }),
            'type_id' => $this->when($this->driver_profile_type_id!=null,function() {return $this->driver_profile_type_id;}),
            'type' => $this->whenPivotLoadedAs('type', DriverProfileType::class, function() {
                return $this->type->name;
            }),
            'cause_id' => $this->when($this->cause_id!=null,function(){return $this->cause_id;}),
            'cause' => $this->whenPivotLoadedAs('cause',DriverProfileCause::class,function() {
                return $this->cause->name;
            }),
            'comment' => $this->when($this->comment!=null,function(){return $this->comment;}),

            'year' => $this->whenPivotLoadedAs('car', DriverProfileCar::class, function () {
               return $this->car->year;
            }),
            'color_id' => $this->whenPivotLoadedAs('car', DriverProfileCar::class, function() {
                return $this->car->color_id ?? null;
            }),
            'car_color' => $this->whenPivotLoadedAs('car', DriverProfileCar::class, function () {
                return $this->car->color->name ?? null;
            }),
            'model_id' => $this->whenPivotLoadedAs('car', DriverProfileCar::class, function() {
                return $this->car->model_id ?? null;
            }),
            'car_model' => $this->whenPivotLoadedAs('car', DriverProfileCar::class, function () {
                return $this->car->model->name ?? null;
            }),
            'car_number' => $this->whenPivotLoadedAs('car', DriverProfileCar::class, function () {
                return $this->car->car_number;
            }),

            'email' => $this->when($this->email!=null,function(){return $this->email;}),
            'gender' => $this->when($this->gender!=null,function(){return $this->gender;}),
            'date_of_birth' => $this->when($this->date_of_birth!=null,function(){return $this->date_of_birth;}),
            'promo_code' => $this->when($this->promo_code!=null,function(){return $this->promo_code;}),
            'type_earning_id' => $this->when($this->type_earning_id!=null,function(){return $this->type_earning_id;}),
            'serials_number' => $this->when($this->serials_number!=null,function(){return $this->serials_number;}),
            'expirated_driver_license' => $this->when($this->expirated_driver_license!=null,function(){return $this->expirated_driver_license;}),
            'serial_number_passport' => $this->when($this->serial_number_passport!=null,function(){return $this->serial_number_passport;}),
            'expirated_passport' => $this->when($this->expirated_passport!=null,function(){return $this->expirated_passport;}),
            'driver_license_type_id' => $this->when($this->driver_license_type_id!=null,function(){return $this->driver_license_type_id;}),
            'driver_license_type' => $this->whenPivotLoadedAs('driver_license_type', DriverLicenseType::class, function(){
                return $this->driver_license_type->name;
            }),
            'passport_office_id' => $this->when($this->passport_office_id!=null,function(){return $this->passport_office_id;}),
            'passport_office' => $this->whenPivotLoadedAs('passport_office', PassportOffice::class,function(){
                return $this->passport_office->name;
            }),
            'district_id' => $this->when($this->district_id!=null,function(){return $this->district_id;}),
            'district' => $this->whenPivotLoadedAs('district', District::class,function(){
                return $this->district->name;
            }),
            'address' => $this->when($this->address!=null,function(){return $this->address;}),
            'created_user' => $this->whenPivotLoadedAs('created_user', User::class, function() {
                return new CreatedUserResource($this->created_user);
            }),
            'color' => $color,
            'reminder_date_at' => $this->reminder_date_at ?? null,
            'reminder_user' =>$this->reminder_user ?? null,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
            'dop_info' => $this->dop_info
        ];
    }
}
