<?php

namespace App\Repositories;

use App\Models\WformItem;
use App\Repositories\Interfaces\IWformItemRepository;


class WformItemRepository implements IWformItemRepository{
    public function getAll()
    {
        return WformItem::with(['whatForm', 'personalDevelopmentForm'])->get();
    }

    public function getById($id)
    {
        return WformItem::with(['whatForm', 'personalDevelopmentForm'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return WformItem::create($data);
    }

    public function update($id, array $data)
    {
        $item = WformItem::find($id);
        if ($item) {
            $item->update($data);
            return WformItem::with(['whatForm', 'personalDevelopmentForm'])->find($id);
        }
        return null;
    }

    public function delete($id)
    {
        $item = WformItem::find($id);
        if ($item) {
            $item->delete();
            return true;
        }
        return false;
    }
}