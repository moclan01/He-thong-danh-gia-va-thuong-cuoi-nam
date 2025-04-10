<?php


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/login', [AuthController::class,'login']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [AuthController::class, 'logout']);

//     Route::get('/profile', [AuthController::class, 'profile']);

// });

// Route::prefix('departments')->group(function () {
//     Route::get('/', [DepartmentController::class, 'index']);   
//     Route::get('/{id}', [DepartmentController::class, 'show']);      
//     Route::post('/', [DepartmentController::class, 'store']);        
//     Route::put('/{id}', [DepartmentController::class, 'update']);   
//     Route::delete('/{id}', [DepartmentController::class, 'destroy']); 
// });

// Route::prefix('employees')->group(function () {
//     Route::get('/', [EmployeeController::class, 'index']);
//     Route::get('{id}', [EmployeeController::class, 'show']);
//     Route::post('/', [EmployeeController::class, 'store']);
//     Route::put('{id}', [EmployeeController::class, 'update']);
//     Route::delete('{id}', [EmployeeController::class, 'destroy']);
// });

// Route::prefix('plants')->group(function () {
//     Route::get('/', [PlantController::class, 'index']);
//     Route::get('{id}', [PlantController::class, 'show']);
//     Route::post('/', [PlantController::class, 'store']);
//     Route::put('{id}', [PlantController::class, 'update']);
//     Route::delete('{id}', [PlantController::class, 'destroy']);
// });