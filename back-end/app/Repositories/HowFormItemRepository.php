<?php

namespace App\Repositories;

use App\Models\HowFormItem;
use App\Repositories\Interfaces\IHowFormItemRepository;

class HowFormItemRepository implements IHowFormItemRepository{
    public function getAll()
    {
        return HowFormItem::with(['howForm', 'hformItem'])->get();
    }

    public function getById($id)
    {
        return HowFormItem::with(['howForm', 'hformItem'])->find($id);
    }

    public function create(array $data)
    {
        return HowFormItem::create($data);
    }

    public function update($id, array $data)
    {
        $item = HowFormItem::find($id);
        if ($item) {
            $item->update($data);
            return HowFormItem::with(['howForm', 'hformItem'])->find($id);
        }
        return null;
    }

    public function delete($id)
    {
        $item = HowFormItem::find($id);
        if ($item) {
            $item->delete();
            return true;
        }
        return false;
    }
}