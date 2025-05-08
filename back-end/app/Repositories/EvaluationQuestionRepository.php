<?php

namespace App\Repositories;

use App\Models\EvaluationQuestion;
use App\Repositories\Interfaces\IEvaluationQuestionRepository;

class EvaluationQuestionRepository implements IEvaluationQuestionRepository{
    public function getAll()
    {
        return EvaluationQuestion::with(['evaluationCriteria', 'evaluationAnswerDetails'])->get();
    }

    public function getById($id)
    {
        return EvaluationQuestion::with(['evaluationCriteria', 'evaluationAnswerDetails'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return EvaluationQuestion::create($data);
    }

    public function update($id, array $data)
    {
        $question = EvaluationQuestion::find($id);
        if ($question) {
            $question->update($data);
            return EvaluationQuestion::with(['evaluationCriteria', 'evaluationAnswerDetails'])->find($id);
        }
        return null;
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