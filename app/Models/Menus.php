<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'public.menuses';
    protected $fillable = ['title', 'description'];

    
}
