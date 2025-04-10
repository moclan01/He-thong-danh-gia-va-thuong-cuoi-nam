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
        // Lấy tất cả nhân viên
        $employees = $this->employeeRepository->getAll();
        return response()->json($employees);
    }

    public function show($id)
    {
        // Hiển thị nhân viên theo mã
        $employee = $this->employeeRepository->getById($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json($employee);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|unique:employees',
            'fullname' => 'required|string',
            'position' => 'required|string',
            'start_date' => 'required|date',
            'type' => 'required|string',
            'division' => 'nullable|string',
            'basic' => 'nullable|string',
            'grade' => 'nullable|string',
            'stafftype' => 'nullable|string',
            'manager_code' => 'nullable|string',
        ]);

        $employee = $this->employeeRepository->create($validatedData);
        return response()->json($employee, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'fullname' => 'nullable|string',
            'position' => 'nullable|string',
            'start_date' => 'nullable|date',
            'type' => 'nullable|string',
            'eligible' => 'nullable|boolean',
            'division' => 'nullable|string',
            'basic' => 'nullable|string',
            'grade' => 'nullable|string',
            'stafftype' => 'nullable|string',
            'manager_code' => 'nullable|string',
        ]);

        $employee = $this->employeeRepository->update($id, $validatedData);

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
}
