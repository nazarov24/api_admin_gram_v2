<?php

namespace App\Http\Controllers\Api\Performer;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerformerRequest\StoreRequest;
use App\Models\Performer;
use App\Services\Performer\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(StoreRequest $request)
    {
        return AuthService::register($request);
    }
}
