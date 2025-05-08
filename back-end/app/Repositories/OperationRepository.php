<?php

namespace App\Repositories;

use App\Models\Operation;
use App\Repositories\Interfaces\IOperationRepository;

class OperationRepository implements IOperationRepository{
    public function getAll()
    {
        return Operation::with('department')->get();
    }

    public function getById($id)
    {
        return Operation::with('department')->find($id);
    }

    public function create(array $data)
    {
        return Operation::create($data);
    }

    public function update($id, array $data)
    {
        $operation = Operation::find($id);
        if ($operation) {
            $operation->update($data);
            // Load lại để có quan hệ department sau khi update
            return Operation::with('department')->find($id);
        }
        return null;
    }

    public function delete($id)
    {
        $operation = Operation::find($id);
        if ($operation) {
            $operation->delete();
            return true;
        }
        return false;
    }
}