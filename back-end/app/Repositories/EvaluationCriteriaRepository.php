<?php

namespace App\Repositories;

use App\Models\EvaluationCriteria;
use App\Repositories\Interfaces\IEvaluationCriteriaRepository;

class EvaluationCriteriaRepository implements IEvaluationCriteriaRepository{
    public function getAll()
    {
        return EvaluationCriteria::with('evaluationQuestions')->get();
    }

    public function getById($id)
    {
        return EvaluationCriteria::with('evaluationQuestions')->find($id);
    }

    public function create(array $data)
    {
        return EvaluationCriteria::create($data);
    }

    public function update($id, array $data)
    {
        $evaluationCriteria = EvaluationCriteria::find($id);

        if (!$evaluationCriteria) {
            return null;
        }

        $evaluationCriteria->update($data);

        return $evaluationCriteria;
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