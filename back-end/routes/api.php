<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CriteriaFormController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EvaluationAnswerController;
use App\Http\Controllers\EvaluationAnswerDetailController;
use App\Http\Controllers\EvaluationCriteriaController;
use App\Http\Controllers\EvaluationCycleController;
use App\Http\Controllers\EvaluationQuestionController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AccountController::class, 'logout']);
    Route::get('employee/profile', [EmployeeController::class, 'getProfile']);
    Route::post('employee/change-password', [EmployeeController::class, 'changePassword']);
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
    Route::get('/code-r/{codeR}', [EmployeeController::class, 'getByCodeR']);
    Route::get('/department/{departmentId}', [EmployeeController::class, 'getByDepartment']);
});

Route::prefix('accounts')->group(function () {
    Route::get('/', [AccountController::class, 'index']);
    Route::post('/', [AccountController::class, 'store']);
    Route::get('/{id}', [AccountController::class, 'show']);
    Route::put('/{id}', [AccountController::class, 'update']);
    Route::delete('/{id}', [AccountController::class, 'destroy']);
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


Route::prefix('criteria-forms')->group(function () {
    Route::get('/', [CriteriaFormController::class, 'index']);
    Route::post('/', [CriteriaFormController::class, 'store']);
    Route::get('/{id}', [CriteriaFormController::class, 'show']);
    Route::put('/{id}', [CriteriaFormController::class, 'update']);
    Route::delete('/{id}', [CriteriaFormController::class, 'destroy']);
    Route::get('/{id}/criterias', [CriteriaFormController::class, 'getCriteriaList']);
});

Route::prefix('evaluation-criterias')->group(function () {
    Route::get('/', [EvaluationCriteriaController::class, 'index']);
    Route::post('/', [EvaluationCriteriaController::class, 'store']);
    Route::get('/{id}', [EvaluationCriteriaController::class, 'show']);
    Route::put('/{id}', [EvaluationCriteriaController::class, 'update']);
    Route::delete('/{id}', [EvaluationCriteriaController::class, 'destroy']);
    Route::get('/{id}/questions', [EvaluationCriteriaController::class, 'getQuestions']);
    Route::put('/{id}/add-criteria', [EvaluationCriteriaController::class, 'addCriteriaToForm']);
});

Route::prefix('evaluation-questions')->group(function () {
    Route::get('/', [EvaluationQuestionController::class, 'index']);
    Route::post('/', [EvaluationQuestionController::class, 'store']);
    Route::get('/{id}', [EvaluationQuestionController::class, 'show']);
    Route::put('/{id}', [EvaluationQuestionController::class, 'update']);
    Route::delete('/{id}', [EvaluationQuestionController::class, 'destroy']);
    Route::get('/{id}/details', [EvaluationQuestionController::class, 'showWithDetails']);
});

Route::prefix('evaluation-answers')->group(function () {
    Route::get('/', [EvaluationAnswerController::class, 'index']);
    Route::get('/{id}', [EvaluationAnswerController::class, 'show']);
    Route::post('/', [EvaluationAnswerController::class, 'store']);
    Route::put('/{id}', [EvaluationAnswerController::class, 'update']);
    Route::delete('/{id}', [EvaluationAnswerController::class, 'destroy']);
    Route::get('/{id}/details', [EvaluationAnswerController::class, 'showWithDetails']);
    Route::get('/employee/{code}', [EvaluationAnswerController::class, 'getByCode']);
    Route::put('/{id}/update-manage-score', [EvaluationAnswerController::class, 'updateTotalScoreManage']);
    Route::put('/{id}/update-supervisor-score', [EvaluationAnswerController::class, 'updateTotalScoreSupervisor']);
    Route::get('/by-code-and-form-id/{code}/{formId}', [EvaluationAnswerController::class, 'getByCodeAndFormId']);
});

Route::prefix('evaluation-answer-details')->group(function () {
    Route::get('/', [EvaluationAnswerDetailController::class, 'index']);
    Route::get('/{id}', [EvaluationAnswerDetailController::class, 'show']);
    Route::post('/', [EvaluationAnswerDetailController::class, 'store']);
    Route::put('/{id}', [EvaluationAnswerDetailController::class, 'update']);
    Route::delete('/{id}', [EvaluationAnswerDetailController::class, 'destroy']);
    Route::post('/employee', [EvaluationAnswerDetailController::class, 'storeByEmployee']);
    Route::put('/{id}/manager', [EvaluationAnswerDetailController::class, 'updateManagerScore']);
    Route::put('/{id}/supervisor', [EvaluationAnswerDetailController::class, 'updateSupervisorScore']);
    Route::put('/{id}/director', [EvaluationAnswerDetailController::class, 'updateDirectorScore']);

    // Batch routes
    Route::post('/employee/batch', [EvaluationAnswerDetailController::class, 'storeByEmployeeBatch']);
    Route::put('/manager/batch', [EvaluationAnswerDetailController::class, 'updateManagerScoresBatch']);
    Route::put('/supervisor/batch', [EvaluationAnswerDetailController::class, 'updateSupervisorScoresBatch']);
    Route::put('/director/batch', [EvaluationAnswerDetailController::class, 'updateDirectorScoresBatch']);
});

Route::get('employees/{code}/evaluation-cycles', [EmployeeController::class, 'getEvaluationCycles']);
Route::get('evaluation-cycles/{cycleId}/criteria-form', [CriteriaFormController::class, 'getFormByCycle']);
Route::get('/employees/department/{departmentId}/employees-only', [EmployeeController::class, 'getEmployeesByDepartmentAndRole']);
Route::get('/employees/department/{id}/managers', [EmployeeController::class, 'getManagersByDepartment']);