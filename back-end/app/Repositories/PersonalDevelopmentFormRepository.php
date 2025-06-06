<?php

namespace App\Repositories;

use App\Models\PersonalDevelopmentForm;
use App\Repositories\Interfaces\IPersonalDevelopmentFormRepository;

class PersonalDevelopmentFormRepository implements IPersonalDevelopmentFormRepository{
    public function getAll()
    {
        return PersonalDevelopmentForm::with(['evaluationCycle', 'items'])->get();
    }

    public function getById($id)
    {
        return PersonalDevelopmentForm::with(['evaluationCycle', 'items'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return PersonalDevelopmentForm::create($data);
    }

    public function update($id, array $data)
    {
        $form = PersonalDevelopmentForm::find($id);
        if ($form) {
            $form->update($data);
            return PersonalDevelopmentForm::with(['evaluationCycle', 'items'])->find($id);
        }
        return null;
    }

    public function delete($id)
    {
        $form = PersonalDevelopmentForm::find($id);
        if ($form) {
            $form->delete();
            return true;
        }
        return false;
    }
}