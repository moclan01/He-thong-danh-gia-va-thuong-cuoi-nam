<?php

namespace App\Repositories;

use App\Models\EvaluationCriteria;
use App\Repositories\Interfaces\IEvaluationCriteriaRepository;

class EvaluationCriteriaRepository implements IEvaluationCriteriaRepository{
    public function getAll()
    {
        return EvaluationCriteria::with(['criteriaForm'])->get();
    }

    public function getById($id)
    {
        return EvaluationCriteria::with(['criteriaForm'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return EvaluationCriteria::create($data);
    }

    public function update($id, array $data)
    {
        $criteria = EvaluationCriteria::find($id);
        if ($criteria) {
            $criteria->update($data);
            return EvaluationCriteria::with(['criteriaForm'])->find($id);
        }
        return null;
    }

    public function delete($id)
    {
        $evaluationCriteria = EvaluationCriteria::find($id);

        if ($evaluationCriteria) {
            $evaluationCriteria->delete();
            return true;
        }

        return false;
    }
}