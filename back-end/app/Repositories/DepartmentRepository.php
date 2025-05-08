<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Interfaces\IDepartmentRepository;

class DepartmentRepository implements IDepartmentRepository {
    public function getAll()
    {
        return Department::with('employee')->get();
    }

    public function getById($id)
    {
        return Department::with('employee')->find($id);
    }

    public function create(array $data)
    {
        return Department::create($data);
    }

    public function update($id, array $data)
    {
        $department = Department::find($id);

        if (!$department) {
            return null;
        }

        $department->update($data);

        return $department;
    }

    public function delete($id)
    {
        $department = Department::find($id);

        if ($department) {
            $department->delete();
            return true;
        }

        return false;
    }
}