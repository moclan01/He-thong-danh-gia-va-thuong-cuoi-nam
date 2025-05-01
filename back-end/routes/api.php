<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EvaluationCycleController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/login', [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

});

Route::prefix('departments')->group(function () {
    Route::get('/', [DepartmentController::class, 'index']);   
    Route::get('/{id}', [DepartmentController::class, 'show']);      
    Route::post('/', [DepartmentController::class, 'store']);        
    Route::put('/{id}', [DepartmentController::class, 'update']);   
    Route::delete('/{id}', [DepartmentController::class, 'destroy']); 
});

Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::get('{id}', [EmployeeController::class, 'show']);
    Route::post('/', [EmployeeController::class, 'store']);
    Route::put('{id}', [EmployeeController::class, 'update']);
    Route::delete('{id}', [EmployeeController::class, 'destroy']);
});

Route::prefix('plants')->group(function () {
    Route::get('/', [PlantController::class, 'index']);
    Route::get('{id}', [PlantController::class, 'show']);
    Route::post('/', [PlantController::class, 'store']);
    Route::put('{id}', [PlantController::class, 'update']);
    Route::delete('{id}', [PlantController::class, 'destroy']);
});


Route::prefix('operations')->group(function () {
    Route::get('/', [OperationController::class, 'index']);
    Route::post('/', [OperationController::class, 'store']);
    Route::get('/{id}', [OperationController::class, 'show']);
    Route::put('/{id}', [OperationController::class, 'update']);
    Route::delete('/{id}', [OperationController::class, 'destroy']);
});

Route::prefix('positions')->group(function () {
    Route::get('/', [PositionController::class, 'index']);
    Route::post('/', [PositionController::class, 'store']);
    Route::get('/{id}', [PositionController::class, 'show']);
    Route::put('/{id}', [PositionController::class, 'update']);
    Route::delete('/{id}', [PositionController::class, 'destroy']);
});

Route::prefix('evaluation-cycles')->group(function () {
    Route::get('/', [EvaluationCycleController::class, 'index']);
    Route::post('/', [EvaluationCycleController::class, 'store']);
    Route::get('/{id}', [EvaluationCycleController::class, 'show']);
    Route::put('/{id}', [EvaluationCycleController::class, 'update']);
    Route::delete('/{id}', [EvaluationCycleController::class, 'destroy']);
});