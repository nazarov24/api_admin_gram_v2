<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class District extends Model
{ 
    use HasFactory;
    public const ACTIVE = 1;
    
    protected $connection = 'pgsql';
    protected $table = 'public.districts';
    protected $fillable = [
        'name',
        'zone_id',
        'population',
        'village_id',
        'polygon',
        'color',
        'lng',
        'lat',
        'is_active'
    ];
   
    public function zone(){
        return $this->belongsTo(Zone::class,'zone_id','id')->with('village');
    }

 
}
