<?php

namespace App\Http\Controllers;

use App\Models\FieldPermission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Swagger\FieldPermissionSwagger;
use Illuminate\Support\Facades\Auth;

class FieldPermissionController extends Controller
{
    
    public function getModelFields($model)
    {
        $modelClass = "App\\Models\\" . ucfirst($model);

        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Model not found'], 404);
        }

        $fields = (new $modelClass)->getFillable();
        return response()->json($fields);
    }

    
    public function getPermissions()
    {
        return response()->json(FieldPermission::all());
        // $user = Auth::user();
        // $role = $user->roles->first();

        // $permissions = FieldPermission::where('role', $role->name)
        //                                 ->where('model', 'users')
        //                                 ->first();

        // if ($permissions) {
        //     $fieldsArray = json_decode($permissions->fields, true);

        //     $fields = array_keys(array_filter($fieldsArray, fn($field) => $field['is_visible'] == 1));

        //     if (!empty($fields)) {
        //         return response()->json(User::select($fields)->get());
        //     }
        // }

        // return response()->json(User::all());

    }

    
    public function updatePermissions(Request $request)
    {
        $user = Auth::user();
        $role = $user->roles->first();
        if ($role->name !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }
    
        $roleExists = Role::where('name', $request->role)->exists();
    
        if (!$roleExists) {
            return response()->json(['error' => 'Role does not exist'], 404);
        }
    
        FieldPermission::updateOrCreate(
            ['role' => $request->role, 'model' => $request->model],
            ['fields' => json_encode($request->fields)]
        );
    
        return response()->json(['message' => 'Permissions updated']);
    }
}
