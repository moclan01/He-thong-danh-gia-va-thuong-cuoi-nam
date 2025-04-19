<?php

namespace App\Repositories;

use App\Models\EvaluationCycle;
use App\Repositories\Interfaces\IEvaluationCycleRepository;

class EvaluationCycleRepository implements IEvaluationCycleRepository{
    public function getAll()
    {
        return EvaluationCycle::with('department')->get();
    }

    public function getById($id)
    {
        return EvaluationCycle::with('department', 'criteriaForms')->find($id);
    }

    public function create(array $data)
    {
        return EvaluationCycle::create($data);
    }

    public function update($id, array $data)
    {
        $cycle = EvaluationCycle::find($id);
        if ($cycle) {
            $cycle->update($data);
            return $cycle;
        }
        return null;
    }

    public function delete($id)
    {
        $cycle = EvaluationCycle::find($id);
        if ($cycle) {
            $cycle->delete();
            return true;
        }
        return false;
    }

}