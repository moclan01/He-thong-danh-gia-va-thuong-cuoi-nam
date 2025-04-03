<?php

namespace App\Http\Controllers;

use App\Repositories\IEmployeeRepository;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(IEmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    // Lấy tất cả employee
    public function index()
    {
        $employees = $this->employeeRepository->getAll();
        return response()->json($employees);
    }

    // Hiển thị thông tin employee theo ID
    public function show($id)
    {
        $employee = $this->employeeRepository->getById($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json($employee);
    }

    // Tạo mới employee
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:employees',
            'plant_id' => 'nullable|string',
            'department_id' => 'nullable|string',
            'fullname' => 'required|string',
            'position' => 'required|string',
            'start_date' => 'required|date',
            'type' => 'required|string',
            'eligible' => 'boolean',
        ]);

        $employee = $this->employeeRepository->create($request->all());

        return response()->json($employee, 201);
    }

    // Cập nhật thông tin employee
    public function update(Request $request, $id)
    {
        $employee = $this->employeeRepository->update($id, $request->all());

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json($employee);
    }

    // Xóa employee
    public function destroy($id)
    {
        $deleted = $this->employeeRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
