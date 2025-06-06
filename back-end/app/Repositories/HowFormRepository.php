<?php

namespace App\Repositories;

use App\Models\HowForm;
use App\Repositories\Interfaces\IHowFormRepository;

class HowFormRepository implements IHowFormRepository{
    public function getAll()
    {
        return HowForm::with('howFormItems')->get();
    }

    public function getById($id)
    {
        return HowForm::with('howFormItems')->find($id);
    }

    public function create(array $data)
    {
        return HowForm::create($data);
    }

    public function update($id, array $data)
    {
        $item = HowForm::find($id);
        if ($item) {
            $item->update($data);
            return HowForm::with('howFormItems')->find($id);
        }
        return null;
    }

    public function delete($id)
    {
        $item = HowForm::find($id);
        if ($item) {
            $item->delete();
            return true;
        }
        return false;
    }
}