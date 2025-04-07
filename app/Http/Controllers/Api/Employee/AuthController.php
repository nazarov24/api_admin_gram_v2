<?php

namespace App\Http\Controllers\Api\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest\StoreRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Employee\AuthService;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Models\Division;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(StoreRequest $request)
    {
        return AuthService::register($request);
    }
    
   
}
