<?php

namespace App\Repositories;

use App\Models\CriteriaForm;
use App\Repositories\Interfaces\ICriteriaFormRepository;

class CriteriaFormRepository implements ICriteriaFormRepository{
    public function getAll()
    {
        return CriteriaForm::with(['evaluationCycle', 'evaluationCriteria'])->get();
    }

    public function getById($id)
    {
        return CriteriaForm::with(['evaluationCycle', 'evaluationCriteria'])->find($id);
    }

    public function create(array $data)
    {
        return CriteriaForm::create($data);
    }

    public function update($id, array $data)
    {
        $criteriaForm = CriteriaForm::find($id);

        if (!$criteriaForm) {
            return null;
        }

        $criteriaForm->update($data);

        return $criteriaForm;
    }

    public function delete($id)
    {
        $criteriaForm = CriteriaForm::find($id);

        if ($criteriaForm) {
            $criteriaForm->delete();
            return true;
        }

        return false;
    }
}