<?php

namespace App\Services;

use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\PermissionRegistrar;

class AuthService
{
    public static function login(array $credentials): JsonResponse
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('YourAppName')->accessToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public static function register(RegisterRequest $request): array
    {
        $validated = $request->validated();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        
        $role = Role::findByName($validated['role'], 'api'); 
        
        if ($role) {
            $user->assignRole($role);
        } else {
            return ['message' => 'Роль не найдена для guard "api"'];
        }

        return [
            'message' => 'Пользователь успешно зарегистрирован',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $validated['role']
            ]
        ];
    }
}
