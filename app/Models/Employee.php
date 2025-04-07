<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'login', 'password', 'avatar', 'division_id', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
