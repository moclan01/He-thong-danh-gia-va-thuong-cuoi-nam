<?php

namespace App\Repositories;

use App\Models\EvaluationCycle;
use App\Repositories\Interfaces\IEvaluationCycleRepository;

class EvaluationCycleRepository implements IEvaluationCycleRepository{
    public function getAll()
    {
        return EvaluationCycle::with(['department', 'criteriaForms'])->get();
    }

    public function getById($id)
    {
        return EvaluationCycle::with(['department', 'criteriaForms'])->findOrFail($id);
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
            return EvaluationCycle::with(['department', 'criteriaForms'])->find($id);
        }
        return null;
    }

    public function delete($id)
    {
        $evaluationCycle = EvaluationCycle::find($id);

        if ($evaluationCycle) {
            $evaluationCycle->delete();
            return true;
        }

        return false;
    }
}