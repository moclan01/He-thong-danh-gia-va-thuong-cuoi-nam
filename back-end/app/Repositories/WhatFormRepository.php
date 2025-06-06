<?php

namespace App\Repositories;

use App\Models\WhatForm;
use App\Repositories\Interfaces\IWhatFormRepository;

class WhatFormRepository implements IWhatFormRepository{
    public function getAll()
    {
        return WhatForm::with(['evaluationCycle', 'items'])->get();
    }

    public function getById($id)
    {
        return WhatForm::with(['evaluationCycle', 'items'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return WhatForm::create($data);
    }

    public function update($id, array $data)
    {
        $whatForm = WhatForm::find($id);
        if ($whatForm) {
            $whatForm->update($data);
            return WhatForm::with(['evaluationCycle', 'items'])->find($id);
        }
        return null;
    }

    public function delete($id)
    {
        $whatForm = WhatForm::find($id);
        if ($whatForm) {
            $whatForm->delete();
            return true;
        }
        return false;
    }
}