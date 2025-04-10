<?php

namespace App\Http\Controllers\Api\DriverProfile;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverProfile\DriverProfileResource;
use App\Models\ColorCar;
use App\Models\District;
use App\Models\Division;
use App\Models\DriverLicenseType;
use App\Models\DriverProfile;
use App\Models\DriverProfileCar;
use App\Models\DriverProfileStatus;
use App\Models\DriverProfileType;
use App\Models\Marka;
use App\Models\PassportOffice;
use App\Services\HistoryOfChangeService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DriverProfileController extends Controller
{

    public function store(Request $request)
    {
        
        try {
            $rule = 'nullable';
            if ($request->has('driver_license_type_id')) {
                if ((int)$request->driver_license_type_id === DriverLicenseType::TJ) {
                    $rule .= '|' . DriverLicenseType::find(DriverLicenseType::TJ)->regex_validation;
                } elseif ((int)$request->driver_license_type_id === DriverLicenseType::RU) {
                    $rule .= '|' . DriverLicenseType::find(DriverLicenseType::RU)->regex_validation;
                } elseif ((int)$request->driver_license_type_id === DriverLicenseType::RU_2) {
                    $rule .= '|' . DriverLicenseType::find(DriverLicenseType::RU_2)->regex_validation;
                }
            }
          
            $validator = Validator::make($request->all(), [
                'division_id' => ['required', Rule::exists(Division::class, 'id')],
                'first_name' => 'nullable|string|min:2|max:50',
                'last_name' => 'nullable|string|min:2|max:50',
                'patronymic' => 'nullable|min:2|max:50',
                'type_id' => ['nullable', Rule::exists(DriverProfileType::class, 'id')],
                'from_time' => 'nullable|date_format:H:i',
                'before_time' => 'nullable|date_format:H:i|after:' . $request->from_time,
                'phone' => 'required|regex:/^992[0-9]{3,14}$/|min:12|max:12',
                'dop_phone' => 'nullable|regex:/^992[0-9]{3,14}$/|min:12|max:12',
                'comment' => 'string',
                'email' => 'string',
                'gender' => 'boolean:0,1',
                'date_of_birth' => 'string|date_format:Y-m-d',
                'promo_code' => 'string',
                'type_earning_id' => 'regex:/^[0-9]$/',
                'driver_license_type_id' => ['nullable', Rule::exists(DriverLicenseType::class, 'id')],
                'serials_number' => $rule,
                'expirated_driver_license' => 'string|date_format:Y-m-d',
                'serial_number_passport' => 'string',
                'expirated_passport' => 'string|date_format:Y-m-d',
                'district_id' => ['nullable', Rule::exists(District::class, 'id')],
                'passport_office_id' => ['nullable', Rule::exists(PassportOffice::class, 'id')],
                'address' => 'nullable|string',
                'year' => 'nullable|numeric',
                'car_number' => ['nullable', 'regex:/[0-9]{3,4}[A-Z]{2}(?:01|02|03|04|05|06|07|08)/', 'max:8'],
                'model_id' => ['nullable', Rule::exists(Marka::class, 'id')],
                'color_id' => ['nullable', Rule::exists(ColorCar::class, 'id')],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $driver_profile = new DriverProfile;
            $driver_profile->division_id = $request->division_id;
            $driver_profile->first_name = $request->first_name ?? null;
            $driver_profile->last_name = $request->last_name ?? null;
            if ($request->patronymic) {
                $driver_profile->patronymic = $request->patronymic;
            }
            $driver_profile->driver_profile_type_id = $request->type_id ?? null;
            $driver_profile->from_time = $request->from_time ?? null;
            $driver_profile->before_time = $request->before_time ?? null;
            $driver_profile->phone = $request->phone;
            $driver_profile->comment = $request->comment ?? null;
            $driver_profile->email = $request->email ?? null;

            $driver_profile->driver_license_type_id = $request->driver_license_type_id ?? null;
            $driver_profile->dop_phone = $request->dop_phone ?? $request->phone;
            $driver_profile->passport_officer_id = $request->passport_office_id ?? null;
            $driver_profile->district_id = $request->district_id ?? null;
            $driver_profile->address = $request->address ?? null;
           
            $status = DriverProfileStatus::firstOrCreate(['name' => 'Поступила'],['name' => 'Поступила']);
           
            $driver_profile->driver_profile_status_id = $status->id;
            $driver_profile->gender = $request->gender ?? null;
            $driver_profile->date_of_birth = $request->date_of_birth ?? null;
            $driver_profile->promo_code = $request->promo_code ?? null;
            // $driver_profile->type_earning_id = $request->type_earning_id ?? null;
            $driver_profile->serials_number = $request->serials_number ?? null;
            // $driver_profile->expirated_driver_license = $request->expirated_driver_license ?? null;
            $driver_profile->serial_number_passport = $request->serial_number_passport ?? null;
            // $driver_profile->expirated_passport = $request->expirated_passport ?? null;
          
            if (Auth::guard('employees-api')->user()->user_id) {
                $driver_profile->user_id = Auth::guard('employees-api')->user()->user_id;
            }
            $driver_profile->save();
            
            $driver_profile_cars = new DriverProfileCar;
            $driver_profile_cars->driver_profile_id = $driver_profile->id;
            $driver_profile_cars->car_number = $request->car_number;
            $driver_profile_cars->year = $request->year;
            $driver_profile_cars->model_id = $request->model_id;
            $driver_profile_cars->color_id = $request->color_id;
            $driver_profile_cars->save();

            return response()->json([
                'message' => 'Анкета создана успешно!',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Произошла системная ошибка!',
                'errors' => $exception->getMessage()
            ], 422);
        }
    }

  

    public function edit($id)
    {
        try {
            $driver_profile = DriverProfile::find($id);
            if ($driver_profile) {
                $driver_profile = new DriverProfileResource($driver_profile);
            }
            return response()->json($driver_profile);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Произошла системная ошибка!',
                'errors' => $exception->getMessage()
            ], 422);
        }
    }

    
    public function update(Request $request, $id)
    {
        try {
            $driver_profile = DriverProfile::find($id);
            if ($driver_profile) {
                $rule = 'nullable';
                if ($request->has('driver_license_type_id')) {
                    if ((int)$request->driver_license_type_id === DriverLicenseType::TJ) {
                        $rule .= '|' . DriverLicenseType::find(DriverLicenseType::TJ)->regex_validation;
                    } elseif ((int)$request->driver_license_type_id === DriverLicenseType::RU) {
                        $rule .= '|' . DriverLicenseType::find(DriverLicenseType::RU)->regex_validation;
                    } elseif ((int)$request->driver_license_type_id === DriverLicenseType::RU_2) {
                        $rule .= '|' . DriverLicenseType::find(DriverLicenseType::RU_2)->regex_validation;
                    }
                }
                $validator = Validator::make($request->all(), [
                    'division_id' => ['required', Rule::exists(Division::class, 'id')],
                    'first_name' => 'nullable|string|min:2|max:50',
                    'last_name' => 'nullable|string|min:2|max:50',
                    'patronymic' => 'nullable|string|min:2|max:50',
                    'type_id' => ['nullable', Rule::exists(DriverProfileType::class, 'id')],
                    'from_time' => 'nullable|date_format:H:i',
                    'before_time' => 'nullable|date_format:H:i|after:' . $request->from_time,
                    'phone' => 'required|regex:/^992[0-9]{3,14}$/|min:12|max:12',
                    'dop_phone' => 'nullable|regex:/^992[0-9]{3,14}$/|min:12|max:12',
                    'comment' => 'nullable|string',
                    'email' => 'nullable|string',
                    'gender' => 'boolean:0,1',
                    'date_of_birth' => 'nullable|date_format:Y-m-d',
                    'promo_code' => 'nullable|string',
                    'type_earning_id' => 'regex:/^[0-9]$/',
                    'driver_license_type_id' => ['nullable', Rule::exists(DriverLicenseType::class, 'id')],
                    'serials_number' => $rule,
                    'expirated_driver_license' => 'string|date_format:Y-m-d',
                    'serial_number_passport' => 'string',
                    'expirated_passport' => 'string|date_format:Y-m-d',
                    'district_id' => ['nullable', Rule::exists(District::class, 'id')],
                    'passport_office_id' => ['nullable', Rule::exists(PassportOffice::class, 'id')],
                    'address' => 'nullable|string',
                    'year' => 'nullable|date_format:Y',
                    'car_number' => 'nullable|string',
                    'model_id' => ['nullable', Rule::exists(Marka::class, 'id')],
                    'color_id' => ['nullable', Rule::exists(ColorCar::class, 'id')],
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'errors' => $validator->errors()
                    ], 422);
                }
                
                DB::beginTransaction();
                $driver_profile->division_id = $request->division_id;
                $driver_profile->first_name = $request->first_name;
                $driver_profile->last_name = $request->last_name;
                $driver_profile->patronymic = $request->patronymic ?? null;
                $driver_profile->driver_profile_type_id = $request->type_id ?? null;
                $driver_profile->from_time = $request->from_time;
                $driver_profile->before_time = $request->before_time;
                $driver_profile->phone = $request->phone;
                $driver_profile->dop_phone = $request->dop_phone ?? null;
                $driver_profile->driver_license_type_id = $request->driver_license_type_id ?? null;
                $driver_profile->passport_officer_id = $request->passport_office_id ?? null;
                $driver_profile->district_id = $request->district_id ?? null;
                $driver_profile->address = $request->address ?? null;
                $driver_profile->comment = $request->comment ?? null;
                $driver_profile->email = $request->email ?? null;
                $driver_profile->gender = $request->gender;
                $driver_profile->date_of_birth = $request->date_of_birth;
                $driver_profile->promo_code = $request->promo_code;
                // $driver_profile->type_earning_id = $request->type_earning_id ?? null;
                $driver_profile->serials_number = $request->serials_number;
                // $driver_profile->expirated_driver_license = $request->expirated_driver_license;
                $driver_profile->serial_number_passport = $request->serial_number_passport;
                // $driver_profile->expirated_passport = $request->expirated_passport;
                // $change_save = new HistoryOfChangeService();
                // $change_save->set_change($driver_profile);
                $driver_profile->update();
               
                $driverProfileCar = DriverProfileCar::where('driver_profile_id', $driver_profile->id)->first();
                if ($driverProfileCar) {
                    $driverProfileCar->car_number = $request->car_number ?? null;
                    $driverProfileCar->model_id = $request->model_id ?? null;
                    $driverProfileCar->color_id = $request->color_id ?? null;
                    $driverProfileCar->year = $request->year ?? null;
                    // $change_save = new HistoryOfChangeService();
                    // $change_save->set_change($driverProfileCar);
                    $driverProfileCar->update();
                } else {
                    if ($request->has('model_id') || $request->has('color_id') || $request->has('year') || $request->has('car_number')) {
                        $driverProfileCar = new DriverProfileCar();
                        $driverProfileCar->driver_profile_id = $driver_profile->id;
                        $driverProfileCar->car_number = $request->car_number ?? null;
                        $driverProfileCar->model_id = $request->model_id ?? null;
                        $driverProfileCar->color_id = $request->color_id ?? null;
                        $driverProfileCar->year = $request->year ?? null;
                        $driverProfileCar->save();
                        $change_save = new HistoryOfChangeService();
                        $change_save->set_change($driverProfileCar);
                    }
                }
                
                DB::commit();
                return response()->json([
                    'message' => 'Анкета успешно изменён!',
                ]);
            } else {
                return response()->json(['message' => 'Not found'], 404);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => 'Произошла системная ошибка!',
                'errors' => $exception->getMessage()
            ], 422);
        }
    }

    
}
