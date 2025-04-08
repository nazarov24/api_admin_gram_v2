<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Models\Client;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Регистрация нового клиента
     */
    public function register(\App\Http\Requests\ClientRequest\StoreRequest $request): JsonResponse
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
