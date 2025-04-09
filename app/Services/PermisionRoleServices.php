<?php

namespace App\Services;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RoleSectionResource;
use App\Http\Resources\SectionResource;
use App\Http\Resources\SubSectionResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Section;
use App\Models\Subsection;
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;

class PermisionRoleServices
{
    public static function getPermissions()
    {
        $users = User::with('roles', 'permissions')->get();

        $data = $users->map(function($user) {
            return [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'roles' => $user->roles->pluck('name'), 
                'permissions' => $user->getAllPermissions()->pluck('name') 
            ];
        });

        return response()->json($data, 200);

    }

    
    public static function assignPermissionsToUser(int $userId, array $permissions): array
    {
        $user = User::findOrFail($userId);

        if ($user->roles->isEmpty()) {
            return ['message' => 'Пользователь не имеет роли. Разрешения не могут быть назначены.'];
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        $permissionNames = Permission::query()->whereIn('id', $permissions)->where('guard_name', 'employees-api')->get();
        
        $user->syncPermissions($permissionNames);
        return [
            'message' => 'Разрешения успешно назначены пользователю.',
            'user_id' => $user->id,
            'assigned_permissions' => $permissionNames,
        ];
    }
    



    public static function removePermissionFromUser($user_id, $permission_id)
    {
        $user = User::findOrFail($user_id);
        $permission = Permission::findOrFail($permission_id);

        $permissionRemoved = false;

        if ($user->hasDirectPermission($permission->name)) {
            $user->revokePermissionTo($permission);
            $permissionRemoved = true;
        }

        foreach ($user->roles as $role) {
            if ($role->hasPermissionTo($permission)) {
                $role->revokePermissionTo($permission);
                $permissionRemoved = true;
            }
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        if ($permissionRemoved) {
            return response()->json(['message' => 'Разрешение успешно удалено у пользователя.'], 200);
        } else {
            return response()->json(['message' => 'У пользователя нет такого разрешения.'], 404);
        }
    }
    


    public static function assignRoleToSubsections(Request $request, $role_id)
    {
        $role = Role::find($role_id);
        if(!$role){return response()->json(['message' => 'Role not found.'], 404);}
        $subsections = Subsection::whereIn('id', $request->subsection_ids)->get();
    
        if ($subsections->isEmpty()) {
            return response()->json(['message' => 'Подразделы не найдены.'], 404);
        }
    
        foreach ($subsections as $subsection) {
            $subsection->roles()->attach($role->id);
        }
    
        return response()->json([
            'message' => 'Роль успешно привязана к подразделам.',
            'role' => new RoleSectionResource($role),
            'subsections' => SubsectionResource::collection($subsections),
        ], 200);
    }
    

}