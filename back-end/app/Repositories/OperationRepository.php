<?php

namespace App\Repositories;

use App\Models\Operation;
use App\Repositories\Interfaces\IOperationRepository;

class OperationRepository implements IOperationRepository{
    public function getAll()
    {
        return Operation::all();
    }

    public function getById($id)
    {
        return Operation::find($id);
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
            return $operation;
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