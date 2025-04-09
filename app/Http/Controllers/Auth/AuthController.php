<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;
use App\Swagger\Auth\AuthSwagger;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');
        $employee = Employee::where('login', $credentials['login'])->first();
        
        if ($employee && Hash::check($credentials['password'], $employee->password)) {
            $token = $employee->createToken('YourAppName')->accessToken;
            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }


}


