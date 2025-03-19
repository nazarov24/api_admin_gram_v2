<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $fillable = ['name', 'guard_name'];

    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions');
    }

    
}
