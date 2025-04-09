<?php

namespace App\Services;

use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\PermissionRegistrar;

class AuthService
{
    public static function login(Request $request)
    {
        return 1;
        $credentials = $request->only('email', 'password');

        if (Auth::guard('employee')->attempt($credentials)) {
            $suda = Auth::guard('employee')->user();
            $token = $suda->createToken('YourAppName')->accessToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    
}
