<?php

namespace App\Repositories;

use App\Models\EvaluationAnswer;
use App\Repositories\Interfaces\IEvaluationAnswerRepository;

class EvaluationAnswerRepository implements IEvaluationAnswerRepository{
    public function getAll()
    {
        return EvaluationAnswer::with(['employee', 'criteriaForm', 'evaluationAnswerDetails'])->get();
    
    }

    public function getById($id)
    {
        return EvaluationAnswer::with(['employee', 'criteriaForm', 'evaluationAnswerDetails'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return EvaluationAnswer::create($data);
    }

    public function update($id, array $data)
    {
        $answer = EvaluationAnswer::find($id);
        if ($answer) {
            $answer->update($data);
            return EvaluationAnswer::with(['employee', 'criteriaForm', 'evaluationAnswerDetails'])->find($id);
        }
        return null;
    }

    public function delete($id)
    {
        $evaluationAnswer = EvaluationAnswer::find($id);

        if ($evaluationAnswer) {
            $evaluationAnswer->delete();
            return true;
        }

        return false;
    }

    public function recalculateTotalScore($id)
    {
        $answer = EvaluationAnswer::with('evaluationAnswerDetails')->find($id);
        if (!$answer) return null;

        $total = $answer->evaluationAnswerDetails->sum('score');
        $answer->update(['total_score' => $total]);

        return $answer;
    }
}