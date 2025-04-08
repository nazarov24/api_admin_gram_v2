<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Services\Client\AuthService;
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
    public function register(\App\Http\Requests\ClientRequest\StoreRequest $request): array
    {
        return AuthService::register($request);
    }
}
