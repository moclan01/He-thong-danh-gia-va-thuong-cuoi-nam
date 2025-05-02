<?php

namespace App\Repositories;

use App\Models\EvaluationQuestion;
use App\Repositories\Interfaces\IEvaluationQuestionRepository;

class EvaluationQuestionRepository implements IEvaluationQuestionRepository{
    public function getAll()
    {
        return EvaluationQuestion::with('evaluationCriteria')->get();
    }

    public function getById($id)
    {
        return EvaluationQuestion::with('evaluationCriteria')->find($id);
    }

    public function create(array $data)
    {
        return EvaluationQuestion::create($data);
    }

    public function update($id, array $data)
    {
        $evaluationQuestion = EvaluationQuestion::find($id);

        if (!$evaluationQuestion) {
            return null;
        }

        $evaluationQuestion->update($data);

        return $evaluationQuestion;
    }

    public function delete($id)
    {
        $evaluationQuestion = EvaluationQuestion::find($id);

        if ($evaluationQuestion) {
            $evaluationQuestion->delete();
            return true;
        }

        return false;
    }
}