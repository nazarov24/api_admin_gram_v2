<?php

namespace App\Services\Client;

use App\Http\Requests\ClientRequest\StoreRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AuthService
{
    public static function register(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();

        try {
            // Генерация случайного пароля
            $password = Str::random(8);

            // Создание пользователя
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->patronymic = $request->patronymic ?? null;
            $user->phone = $request->phone;
            $user->second_phone = $request->second_phone;
            $user->email = $request->email;
            $user->birth_date = $request->birth_date;
            $user->gender = $request->gender;
            $user->save();

            // Создание клиента
            $client = new Client();
            $client->user_id = $user->id;
            $client->login = $request->phone;
            $client->password = Hash::make($password);
            $client->fcm_token = $request->fcm_token ?? null;
            $client->division_id = $request->division_id;
            $client->status = $request->status;
            $client->is_online = $request->is_online;
            $client->dop_info = $request->dop_info ?? null;
            $client->device = $request->device ?? 'unknown';

            // Загрузка аватара, если он был отправлен
            if ($request->hasFile('avatar')) {
                $path = $request->file('avatar')->store('client_avatars', 'public');
                $client->avatar = $path;
            }

            $client->save();

            DB::commit();

            return response()->json([
                'message' => 'Клиент успешно зарегистрирован!',
                'login' => $client->login,
                'password' => $password,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Произошла системная ошибка!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
