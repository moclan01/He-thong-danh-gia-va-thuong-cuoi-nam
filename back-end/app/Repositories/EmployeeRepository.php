<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\Interfaces\IEmployeeRepository;

class EmployeeRepository implements IEmployeeRepository{
    public function getAll()
    {
        return Employee::with(['account', 'plant', 'department', 'position', 'manager'])->get();
    }

    public function getById($code)
    {
        return Employee::with(['account', 'plant', 'department', 'position', 'manager'])->where('code', $code)->first();
    }

    public function create(array $data)
    {
        return Employee::create($data);
    }

    public function update($code, array $data)
    {
        $employee = Employee::where('code', $code)->first();
        if ($employee) {
            $employee->update($data);
            return Employee::with(['account', 'plant', 'department', 'position', 'manager'])->where('code', $code)->first();
        }
        return null;
    }

    public function delete($code)
    {
        $employee = Employee::where('code', $code)->first();
        if ($employee) {
            $employee->delete();
            return true;
        }
        return false;
    }

    public function getEmployeesByDepartment($departmentId)
    {
        return Employee::where('department_id', $departmentId)->get();
    }

    public function getSubordinates($managerCode)
    {
        return Employee::where('manager_code', $managerCode)->get();
    }
}