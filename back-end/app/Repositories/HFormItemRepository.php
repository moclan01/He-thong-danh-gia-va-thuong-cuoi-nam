<?php

namespace App\Repositories;

use App\Models\HformItem;
use App\Repositories\Interfaces\IHFormItemRepository;

class HFormItemRepository implements IHFormItemRepository{
    public function getAll()
    {
        return HFormItem::with('totalCriteriaScore')->get();
    }

    public function getById($id)
    {
        return HFormItem::with('totalCriteriaScore')->find($id);
    }

    public function create(array $data)
    {
        return HFormItem::create($data);
    }

    public function update($id, array $data)
    {
        $item = HFormItem::find($id);
        if ($item) {
            $item->update($data);
            return HformItem::with('totalCriteriaScore')->find($id);
        }
        return null;
    }

    public function delete($id)
    {
        $item = HFormItem::find($id);
        if ($item) {
            $item->delete();
            return true;
        }
        return false;
    }
}