<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PassportOffice extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'passport_office';
}
