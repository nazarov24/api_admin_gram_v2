<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryOfChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'is_dirty_old',
        'employee_id',
        'model_type',
        'model_id',
    ];

    public function user() {
        return $this->belongsTo(User::class,'employee_id','id');
    }
}
