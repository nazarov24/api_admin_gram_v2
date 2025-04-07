<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverBalance extends Model
{
     protected $connection = 'pgsql';
     protected $table = 'public.driver_balances';

    use HasFactory;
    protected $fillable = [
        'performer_id',
        'balance',
        'additional_balance'
    ];
    const ACCOUNT_ID_COLUMN = 'performer_id';
    protected $primaryKey = 'performer_id';
}
