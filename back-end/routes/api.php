<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PlantController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Đảm bảo không có route nào không cần xác thực trong nhóm này (ví dụ login)
Route::post('/login', [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

});

// Department routes
Route::prefix('departments')->group(function () {
    Route::get('/', [DepartmentController::class, 'index']);   
    Route::get('/{id}', [DepartmentController::class, 'show']);      
    Route::post('/', [DepartmentController::class, 'store']);        
    Route::put('/{id}', [DepartmentController::class, 'update']);   
    Route::delete('/{id}', [DepartmentController::class, 'destroy']); 
});

// Employee routes
Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::get('{id}', [EmployeeController::class, 'show']);
    Route::post('/', [EmployeeController::class, 'store']);
    Route::put('{id}', [EmployeeController::class, 'update']);
    Route::delete('{id}', [EmployeeController::class, 'destroy']);
});

// Plant routes
Route::prefix('plants')->group(function () {
    Route::get('/', [PlantController::class, 'index']);
    Route::get('{id}', [PlantController::class, 'show']);
    Route::post('/', [PlantController::class, 'store']);
    Route::put('{id}', [PlantController::class, 'update']);
    Route::delete('{id}', [PlantController::class, 'destroy']);
});
