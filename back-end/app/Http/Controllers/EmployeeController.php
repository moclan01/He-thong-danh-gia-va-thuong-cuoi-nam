<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EvaluationCycle;
use App\Repositories\Interfaces\IEmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(IEmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;

        $this->middleware('auth:sanctum');
    }



    public function index()
    {
        $employees = $this->employeeRepository->getAll();
        return response()->json($employees);
    }

    public function show($code)
    {
        $employee = $this->employeeRepository->getById($code);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        return response()->json($employee);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:employees,code',
            'plant_id' => 'nullable|exists:plants,plant_id',
            'department_id' => 'nullable|exists:departments,department_id',
            'position_id' => 'nullable|exists:positions,position_id',
            'code_r' => 'nullable|exists:employees,code',
            'fullname' => 'required|string',
            'division' => 'required|string',
            'basic' => 'required|string',
            'grade' => 'required|string',
            'stafftype' => 'required|string',
            'start_date' => 'required|date',
            'type' => 'required|string',
        ]);

        $employee = $this->employeeRepository->create($request->all());

        return response()->json($employee, 201);
    }

    public function update(Request $request, $code)
    {
        $validated = $request->validate([
            'plant_id' => 'nullable|exists:plants,plant_id',
            'department_id' => 'nullable|exists:departments,department_id',
            'position_id' => 'nullable|exists:positions,position_id',
            'code_r' => 'nullable|string|exists:employees,code',
            'fullname' => 'required|string|max:255',
            'division' => 'required|string|max:100',
            'basic' => 'required|string|max:50',
            'grade' => 'required|string|max:50',
            'stafftype' => 'required|string|max:50',
            'start_date' => 'required|date',
            'type' => 'required|string|max:50',
        ]);

        $employee = $this->employeeRepository->update($code, $validated);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json($employee);
    }

    public function destroy($code)
    {
        $deleted = $this->employeeRepository->delete($code);
        if (!$deleted) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        return response()->json(['message' => 'Employee deleted successfully']);
    }

    public function getProfile(Request $request)
    {
        $account = Auth::user();
        if (!$account) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $employee = $this->employeeRepository->getById($account->code);
        if (!$employee) {
            return response()->json(['message' => 'Employee profile not found'], 404);
        }

        $safeEmployee = $employee->only([
            'code',
            'plant_id',
            'department_id',
            'position_id',
            'code_r',
            'fullname',
            'division',
            'basic',
            'grade',
            'stafftype',
            'start_date',
            'type'
        ]);

        $profile['plant_name'] = $employee->plant->plant_name ?? null;
        $profile['department_name'] = $employee->department->department_name ?? null;
        $profile['position_name'] = $employee->position->position_name ?? null;
        $profile['manager_name'] = $employee->manager->fullname ?? null;

        return response()->json($safeEmployee);
    }

    public function changePassword(Request $request)
    {
        $account = $request->user();
        if (!$account) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $account->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 401);
        }

        $account->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return response()->json(['message' => 'Password changed successfully']);
    }

    public function getByCodeR($codeR)
    {
        $employees = Employee::where('code_r', $codeR)->get();
        return response()->json($employees);
    }

    public function getByDepartment($departmentId)
    {
        $employees = Employee::where('department_id', $departmentId)->get();
        return response()->json($employees);
    }

    public function getEvaluationCycles($code)
    {
        $employee = $this->employeeRepository->getById($code);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $departmentId = $employee->department_id;

        if (!$departmentId) {
            return response()->json(['message' => 'Employee has no department assigned'], 404);
        }

        $evaluationCycles = EvaluationCycle::where('department_id', $departmentId)->get();

        return response()->json($evaluationCycles);
    }

    public function getEmployeesByDepartmentAndRole($departmentId)
    {
        $employees = Employee::where('department_id', $departmentId)
            ->whereHas('account', function ($query) {
                $query->where('role', 'employee');
            })
            ->get();

        return response()->json($employees);
    }

    public function getManagersByDepartment($departmentId)
    {
        $employees = Employee::where('department_id', $departmentId)
            ->whereHas('account', function ($query) {
                $query->where('role', 'manager');
            })
            ->get();

        return response()->json($employees);
    }
}
