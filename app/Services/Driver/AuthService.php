<?php

namespace App\Services\Driver;

use App\Http\Requests\DriverRequest\StoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Division;
use App\Models\DriverBalance;
use App\Models\DriverCar;
use App\Models\Performer;
use App\Models\PerformerOption;
use App\Models\PerformerTransport;
use Illuminate\Support\Carbon;


class AuthService
{
    public static function register(StoreRequest $request)
    {
        try { 
            $performer = Performer::where('division_id', $request->division_id)
                ->whereHas('user', function ($query) use ($request) {
                    $query->where('phone', $request->phone);
                })
                ->with('user')
                ->first();


             if ($performer) {
                 return response()->json([
                     'errors' => 'Такой пользователь в текущим подразделение уже существует!'
                 ], 422);
             }
             $division = Division::find($request->division_id);
             if ($division) {
                 $city_id = $division->city_id;
             } else {
                 $city_id = null;
             }
             DB::beginTransaction();

             $user = new User();
             $user->first_name = $request->first_name ?? null;
             $user->last_name = $request->last_name ?? null;
             if ($request->patronymic) {
                 $user->patronymic = $request->patronymic;
             }
             $user->phone = $request->phone;
             $user->second_phone = $request->second_phone ?? $request->phone;
             $user->birth_date = $request->date_of_birth ?? null;
             $user->gender = $request->gender ?? null;
             $user->email = $request->email ?? 1;
             $user->save();
             
             $driver = new Performer();
             
             $driver->user_id = $user->id;
             $driver->division_id = $request->division_id;
             $driver->promo_code = $request->promo_code ?? null;
             $driver->city_id = $city_id;
             if ($request->passport_serial) {
                $driver->passport_serials = $request->passport_serial;
            } else {
                $driver->passport_serials = null;
            }
            
            $driver->driver_license_serials = $request->driver_license_serial ?? null;
            $driver->expirated_driver_license = $request->expirated_driver_license ?? null;
            $driver->expirated_passport = $request->expirated_passport ?? null;
            $driver->address = $request->address ?? null;
            $driver->rating = $request->rating ?? 95;
            $driver->status = Performer::DISABLE ?? null;
            $id = (string)$user->id;
            $str = str_repeat("0", abs(6 - strlen($id)));
            $login = $str . $id;
            $driver->login = $login;
            $driver->update();
            $password = (string)rand(100000, 999999);
            $driver->password = bcrypt($password);
            $driver->is_free = $request->is_free ?? 1;
            $driver->fcm_token = $request->fcm_token ?? null;
            $driver->register_from = "admin" ?? null;
            $driver->dop_info = $request->dop_info ?? null;
            $driver->created_by =  auth()->id ?? null;    
            // $expired_password = config('sip-gram.expired_password');
            $expired_password = 30;
            $password_changed_at = Carbon::now()->addDays($expired_password);
            
            $driver->password_changed_at = $password_changed_at;
            $driver->is_on_shift = $request->is_on_shift ?? 1;
            $driver->is_online = $request->is_online ?? 1;
            $driver->socket_id = $request->socked_id ?? null;
            $driver->rating_by_client = $request->rating_by_client ?? 1;
            $driver->activity = $request->activity ?? 1;
            $driver->save();
            
            if ($request->has('car_id')) {
                DriverCar::updateOrCreate([
                    'driver_id' => $driver->id,
                    'car_id' => $request->car_id,
                ], [
                    'driver_id' => $driver->id,
                    'car_id' => $request->car_id,
                ]);
 
                 $car = PerformerTransport::find($request->car_id);
                 $car->performer_id = $driver->id;
                 $car->connected_id = PerformerTransport::ACTIVE_CONNECTION;
                 $car->active = PerformerTransport::ACTIVE;
                 $car->save();
             }
             DriverBalance::create([
                 'balance' => 0,
                 'performer_id' => $driver->id,
             ]);
             if ($request->gender == 0) {
                 $performer_option = PerformerOption::where('slag', 'woman_driving')->first();
                 if ($performer_option) {
                     $option_id = $performer_option->id;
                 } else {
                     $performer_option = PerformerOption::create(
                         [
                             'name' => 'Женщина за рулём',
                             'slag' => 'woman_driving'
                         ]
                     );
                     $option_id = $performer_option->id;
                 }
                 
             }
             DB::commit();
            //  PromoCodeService::generate_promo_code_for_performer($driver->id, $driver->login);
            //  PhotoControlService::add_to_perfomer_p_c($driver->id, SettingAutoAssignPhotoControl::EVENT_NEW_PERFORMER);
            //  if ($request->has('car_id') && isset($car)) {
            //      PhotoControlService::add_to_perfomer_p_c($driver->id, SettingAutoAssignPhotoControl::EVENT_NEW_CAR, $car->id);
            //  }
             $phone_number = $driver->phone;
             $body = "Ваш логин: " . $driver->login . " \nВаш пароль: " . $password . " \nПриложение:" . config('sip-gram.mobile_app_url');
 
             $result = [
                 'message' => 'Водитель успе-шно зарегистрирован!',
                 'result' => $body,
             ];
            //  if (!app()->isProduction()) {
            //      $result['Log_in'] = $body;
            //  } else {
            //      dispatch(new SendSms($phone_number, $body));
            //  }
            //  (new PerformerTariffService)->set_tariff_v2($car->id);
             return response()->json($result);
         } catch (\Exception $exception) {
             DB::rollback();
             return response()->json([
                 'message' => 'Произошла системная ошибка!',
                 'errors' => $exception->getMessage()
             ], 422);
         }
    }
    
}
