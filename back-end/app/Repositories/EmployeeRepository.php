<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository implements IEmployeeRepository
{
    public function getAll()
    {
        return Employee::with(['plant', 'department'])->get(); 
    }

    public function getById($id)
    {
        return Employee::with(['plant', 'department'])->find($id);
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
}