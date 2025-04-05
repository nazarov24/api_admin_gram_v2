<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
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
        $credentials = $request->only('email', 'password');
        return AuthService::login($credentials);
    }


    public function register(RegisterRequest $request)
    {
        $result = AuthService::register($request);
        return response()->json($result, 201);
    }

}


