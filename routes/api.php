<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//auth
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    //auth
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::put('/auth/update', [AuthController::class, 'update']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    //roles
    Route::get('/roles', [RoleController::class, 'index'])->middleware('permission:view_roles');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->middleware('permission:view_roles');
    Route::post('/roles', [RoleController::class, 'store'])->middleware('permission:create_roles');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('permission:update_roles');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->middleware('permission:delete_roles');

    //permissions
    Route::get('/permissions', [PermissionController::class, 'index'])->middleware('permission:view_permissions');
    Route::get('/permissions/{permission}', [PermissionController::class, 'show'])->middleware('permission:view_permissions');
    Route::post('/permissions', [PermissionController::class, 'store'])->middleware('permission:create_permissions');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->middleware('permission:update_permissions');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->middleware('permission:delete_permissions');

    //users
    Route::get('/users', [UserController::class, 'index'])->middleware('permission:view_users');
    Route::get('/users/{user}', [UserController::class, 'show'])->middleware('permission:view_users');
    Route::post('/users', [UserController::class, 'store'])->middleware('permission:create_users');
    Route::put('/users/{user}', [UserController::class, 'update'])->middleware('permission:update_users');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('permission:delete_users');
});
