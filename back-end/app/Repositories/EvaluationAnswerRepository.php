<?php

namespace App\Repositories;

use App\Models\EvaluationAnswer;
use App\Repositories\Interfaces\IEvaluationAnswerRepository;

class EvaluationAnswerRepository implements IEvaluationAnswerRepository{
    public function getAll()
    {
        return EvaluationAnswer::with(['employee', 'criteriaForm'])->get();
    }

    public function getById($id)
    {
        return EvaluationAnswer::with(['employee', 'criteriaForm'])->find($id);
    }

    public function create(array $data)
    {
        return EvaluationAnswer::create($data);
    }

    public function update($id, array $data)
    {
        $evaluationAnswer = EvaluationAnswer::find($id);

        if (!$evaluationAnswer) {
            return null;
        }

        $evaluationAnswer->update($data);

        return $evaluationAnswer;
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
}