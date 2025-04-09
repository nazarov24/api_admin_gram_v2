<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory, SoftDeletes;
    use HasApiTokens;
    use HasRoles;

    protected $guard_name = 'employees';

    protected $fillable = [
        'user_id', 'login', 'password', 'avatar', 'division_id', 'status',
    ];

    // protected $hidden = ['password', 'remember_token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
