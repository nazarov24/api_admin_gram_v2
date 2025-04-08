<?php

namespace App\Services\Performer;

use App\Http\Requests\PerformerRequest\StoreRequest;
use App\Models\User;
use App\Models\Performer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    public static function register(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            if (User::where('email', $request->email)->exists()) {
                return response()->json([
                    'message' => 'Email allaqachon mavjud.',
                    'errors' => ['email' => 'Ushbu email band.']
                ], 422);
            }

            $password = Str::random(8);

            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($password);
            $user->save();

            $performer = new Performer();
            $performer->user_id = $user->id;
            $performer->division_id = $request->division_id;
            $performer->city_id = $request->city_id;
            $performer->promo_code = $request->promo_code;
            $performer->passport_serials = $request->passport_serials;
            $performer->driver_license_serials = $request->driver_license_serials;
            $performer->expirated_driver_license = $request->expirated_driver_license;
            $performer->expirated_passport = $request->expirated_passport;
            $performer->address = $request->address;
            $performer->login = $request->phone;
            $performer->password = Hash::make($password);
            $performer->fcm_token = $request->fcm_token;
            $performer->register_from = $request->register_from;
            $performer->dop_info = $request->dop_info;
            $performer->created_by = auth()->id();
            $performer->save();

            DB::commit();

            return response()->json([
                'message' => 'Performer muvaffaqiyatli ro‘yxatdan o‘tdi.',
                'data' => [
                    'login' => $performer->login,
                    'password' => $password
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Serverda xatolik yuz berdi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

