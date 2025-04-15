<?php

use App\Http\Controllers\Api\Driver\DriverController;
use App\Http\Controllers\Api\DriverProfile\DriverProfileController;
use App\Http\Controllers\Api\Employee\AuthController as EmployeeAuthController;
use App\Http\Controllers\Api\Orders\JournalOrderController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FieldPermissionController;
use App\Http\Controllers\MenusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Roles\PermissionController;
use App\Http\Controllers\Roles\PermisionRoleController;
use App\Http\Controllers\SectionController;

Route::prefix('auth')->group(function (){
    Route::post('employees/users', [EmployeeAuthController::class, 'register']);
    Route::post('drivers/register', [DriverController::class, 'store']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('roles')->group(function (){
    Route::get('/', [RoleController::class, 'index']);
    Route::post('/', [RoleController::class, 'store']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);
    Route::post('users/{user_id}/roles', [RoleController::class, 'assignRoleToUser']);
});

Route::prefix('permissions')->group(function (){
    Route::get('/', [PermissionController::class, 'index']);
    Route::post('/', [PermissionController::class, 'store']);
    Route::put('/{id}', [PermissionController::class, 'update']);
    Route::delete('/{id}/delete', [PermissionController::class, 'destroy']);
});

Route::middleware('auth:employees-api')->group(function () {
    Route::post('role/{id}/permissions', [PermisionRoleController::class, 'assignPermissions']);
    Route::get('role/permissions', [PermisionRoleController::class, 'getPermissions']);
    Route::delete('role/{user_id}/permissions/{permission_id}', [PermisionRoleController::class, 'removePermissionById']);
});

// Подраздел
Route::prefix('sections')->group(function (){
    Route::get('/index', [SectionController::class, 'index']);
    Route::post('/', [SectionController::class, 'store']);
    Route::put('/{id}', [SectionController::class, 'update']);
    Route::post('/{id}/subsections', [SectionController::class, 'addSubsection']);
    Route::delete('/{id}', [SectionController::class, 'destroy']);
    Route::post('/{role_id}/roles', [PermisionRoleController::class, 'assignSectionsToRole']);
    Route::post('/roles/{role_id}/subsections', [PermisionRoleController::class, 'assignRoleToSubsections']);
});

Route::prefix('menus')->middleware('auth:employees-api')->group(function () {
    Route::post('/', [MenusController::class, 'store'])->middleware('permission:created posts');
    Route::get('/index', [MenusController::class, 'index'])->middleware('permission:show posts');
    Route::put('/{id}', [MenusController::class, 'update'])->middleware('permission:edit posts');
    Route::delete('/{id}', [MenusController::class, 'destroy'])->middleware('permission:delate posts');
});


Route::prefix('driver-profiles')->middleware('auth:employees-api')->group(function () {
    Route::post('/', [DriverProfileController::class, 'store']);
    Route::get('/{driver_profile_id}/edit', [DriverProfileController::class, 'edit']);
    Route::patch('/{driver_profile_id}', [DriverProfileController::class, 'update']);
});
Route::get('orders/journals',[JournalOrderController::class, 'journals']);








