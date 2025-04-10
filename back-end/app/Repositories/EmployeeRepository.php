<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\Interfaces\IEmployeeRepository;

class EmployeeRepository implements IEmployeeRepository{
    public function getAll()
    {
        return Employee::all();
    }

    public function getById($id)
    {
        return Employee::find($id);
    }

    public function create(array $data)
    {
        return Employee::create($data);
    }

    public function update($id, array $data)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return null; 
        }

        $employee->update($data);
        return $employee;
    }

    public function delete($id)
    {
        $employee = Employee::find($id);

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

    // Lấy các nhân viên dưới quyền của một trưởng phòng
    public function getSubordinates($managerCode)
    {
        return Employee::where('manager_code', $managerCode)->get();
    }
}