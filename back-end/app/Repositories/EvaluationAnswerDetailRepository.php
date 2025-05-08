<?php

namespace App\Repositories;

use App\Models\EvaluationAnswerDetail;
use App\Repositories\Interfaces\IEvaluationAnswerDetailRepository;

class EvaluationAnswerDetailRepository implements IEvaluationAnswerDetailRepository{
    public function getAll()
    {
        return EvaluationAnswerDetail::with(['evaluationQuestion', 'evaluationAnswer'])->get();
    }

    public function getById($id)
    {
        return EvaluationAnswerDetail::with(['evaluationQuestion', 'evaluationAnswer'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return EvaluationAnswerDetail::create($data);
    }

    public function update($id, array $data)
    {
        $detail = EvaluationAnswerDetail::find($id);
        if ($detail) {
            $detail->update($data);
            return EvaluationAnswerDetail::with(['evaluationQuestion', 'evaluationAnswer'])->find($id);
        }
        return null;
    }

    public function delete($id)
    {
        $evaluationAnswerDetail = EvaluationAnswerDetail::find($id);

        if ($evaluationAnswerDetail) {
            $evaluationAnswerDetail->delete();
            return true;
        }

        return false;
    }
}