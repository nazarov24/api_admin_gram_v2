<?php

namespace App\Http\Controllers\Api\Orders;


use App\Http\Controllers\Controller;
use App\Services\Order\JournalOrderService;
use Illuminate\Http\Request;

class JournalOrderController extends Controller
{
    public function journals(Request $request): \Illuminate\Http\JsonResponse
    {

        return JournalOrderService::journals($request);
    }
}
