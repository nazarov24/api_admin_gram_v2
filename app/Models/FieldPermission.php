<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldPermission extends Model
{
    protected $fillable = ['role', 'model', 'fields'];

   
    protected $casts = [
        'fields' => 'array'
    ];
}
