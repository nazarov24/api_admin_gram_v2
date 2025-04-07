<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\DriverRequest\StoreRequest;
use App\Services\Driver\AuthService;
use App\Swagger\DriverSwagger\DriverSwagger;

class DriverController extends Controller
{
    public function store(StoreRequest $request)
    {
        return AuthService::register($request);
    }
}
