<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IDepartmentRepository;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $departmentRepository;

    public function __construct(IDepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function index()
    {
        $departments = $this->departmentRepository->getAll();
        return response()->json($departments);
    }

    public function show($id)
    {
        $department = $this->departmentRepository->getById($id);

        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        return response()->json($department);
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|string|unique:departments',
            'manage_code' => 'nullable|string',
            'department_name' => 'required|string',
        ]);

        $department = $this->departmentRepository->create($request->all());

        return response()->json($department, 201);
    }

    public function update(Request $request, $id)
    {
        $department = $this->departmentRepository->update($id, $request->all());

        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        return response()->json($department);
    }

    public function destroy($id)
    {
        $deleted = $this->departmentRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        return response()->json(['message' => 'Department deleted successfully']);
    }
}
