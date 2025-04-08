<?php

namespace App\Models;

use App\Traits\FiltersTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Client extends Authenticatable
{
    protected $table = 'clients';
    const USER = 'CLIENT';
    protected $connection = 'pgsql';
    use HasApiTokens, HasFactory, Notifiable;
    public const LIMIT_DATA = 100;
    protected $fillable = [
        'id',
        'phone',
        'first_name',
        'last_name',
        'patronimyc',
        'gender',
        'birth_date',
        'email',
        'password',
        'fcm_token',
        'login',
        'user_id',
             'socket_id',
        'is_online',
        'division_id',
        'id_num_passport',
        'dop_info',
        'is_active',
        'patronymic',
        'balance',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'client_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function balance()
    {
        return $this->hasOne(ClientBalance::class);
    }
}
