<?php

namespace App\Services\Employee;

use App\Http\Requests\EmployeeRequest\StoreRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class AuthService
{
    public static function register(StoreRequest $request)
    {
        try {

            $email = $request->email;
            $emailExists = User::where('email', $email)->exists();

            if ($emailExists) {
                return response()->json([
                    'message' => 'Email уже существует',
                    'errors' => ['email' => 'Этот email уже используется.']
                ], 422);
            }

            $user = new User();
            $password = Str::random(8);
            
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            if ($request->patronymic) {
                $user->patronymic = $request->patronymic;
            }
            $user->phone = $request->phone;
            $user->second_phone = $request->second_phone;
            $user->birth_date = $request->birth_date;
            $user->gender = $request->gender;
            $user->email = $request->email;
            $role = Role::findByName($request->role, 'api'); 
            if ($role) {
                $user->assignRole($role);
            } else {
                return ['message' => 'Роль не найдена для guard "api"'];
            }
            $user->save();
            
            $path = $request->file('avatar')->store('avatars', 'public');
            
            $employee = new Employee();
            $employee->division_id = $request->division_id;
            $employee->user_id = $user->id;
            $employee->login = $request->phone;
            $employee->password = bcrypt($password);
            $employee->avatar = $path;
            $employee->save();
            $body = "Ваш логин: " . $employee->login . ". \nВаш пароль: " . $password . ".";
            return 
                response()->json(['message' => 'Registеr successfully',
                'Log_in' => $body
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Произошла системная ошибка!',
                'errors' => $exception->getMessage()
            ], 404);
        }
    }
    
}
