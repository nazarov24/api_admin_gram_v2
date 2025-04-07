<?php

namespace App\Http\Controllers\Api\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest\StoreRequest;
use App\Http\Requests\RegisterRequest;
use App\Swagger\Employee\EmployeeSwagger;
use App\Services\Employee\AuthService;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    public function register(StoreRequest $requests)
    {
        DB::beginTransaction();
        try { 
            $user = new User();
            $password = Str::random(8);
            $user->first_name = $requests->first_name;
            $user->last_name = $requests->last_name;
            if ($requests->patronymic) {
                $user->patronymic = $requests->patronymic;
            }
            $user->phone = $requests->phone;
            $user->second_phone = $requests->second_phone;
            $user->birth_date = $requests->birth_date;
            $user->gender = $requests->gender;
            $user->email = $requests->email;
            
            $role = Role::findByName($requests['role'], 'api'); 
            if ($role) {
                $user->assignRole($role);
            } else {
                return ['message' => 'Роль не найдена для guard "api"'];
            }
            $user->save();
            
            $path = $requests->file('avatar')->store('avatars', 'public');

            $employee = new Employee();
            $employee->division_id = $requests->division_id;
            $employee->user_id = $user->id;
            $employee->login = $requests->phone;
            $employee->password = bcrypt($password);
            $employee->avatar = $path;
            $employee->save();
            $body = "Ваш логин: " . $employee->login . ". \nВаш пароль: " . $password . ".";
            return 
                response()->json(['message' => 'Registеr successfully',
                'Log_in' => $body
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => 'Произошла системная ошибка!',
                'errors' => $exception->getMessage()
            ], 404);
        }
    }
    
   
}

