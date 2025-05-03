<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IEmployeeRepository;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(IEmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        $employees = $this->employeeRepository->getAll();
        return response()->json($employees);
    }

    public function show($id)
    {
        $employee = $this->employeeRepository->getById($id);

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

    public function update(Request $request, $id)
    {
        $request->validate([
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

        $employee = $this->employeeRepository->update($id, $request->all());

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json($employee);
    }

    public function destroy($id)
    {
        $deleted = $this->employeeRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json(['message' => 'Employee deleted successfully']);
    }

    public function getProfile(Request $request)
    {
        $account = $request->user();

        if (!$account) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }


        $employee = $this->employeeRepository->getByCode($account->code);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json([
            'account' => [
                'id' => $account->id,
                'username' => $account->username,
                'role' => $account->role,
                'code' => $account->code,
                'status' => $account->status,
            ],
            'employee' => $employee,
        ], 200);
    }
}
