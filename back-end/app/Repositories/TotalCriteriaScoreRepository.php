<?php

namespace App\Repositories;

use App\Models\TotalCriteriaScore;
use App\Repositories\Interfaces\ITotalCriteriaScoreRepository;

class TotalCriteriaScoreRepository implements ITotalCriteriaScoreRepository{
    public function getAll()
    {
        return TotalCriteriaScore::with(['evaluationAnswer', 'evaluationCriteria'])->get();
    }

    public function getById($id)
    {
        return TotalCriteriaScore::with(['evaluationAnswer', 'evaluationCriteria'])->find($id);
    }

    public function create(array $data)
    {
        return TotalCriteriaScore::create($data);
    }

    public function update($id, array $data)
    {
        $item = TotalCriteriaScore::find($id);
        if ($item) {
            $item->update($data);
            return TotalCriteriaScore::with(['evaluationAnswer', 'evaluationCriteria'])->find($id);
        }
        return null;
    }

    public function delete($id)
    {
        $item = TotalCriteriaScore::find($id);
        if ($item) {
            $item->delete();
            return true;
        }
        return false;
    }
}