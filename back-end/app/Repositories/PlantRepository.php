<?php

namespace App\Repositories;

use App\Models\Plant;
use App\Repositories\Interfaces\IPlantRepository;

class PlantRepository implements IPlantRepository
{
    public function getAll()
    {
        return Plant::with('employees')->get();
    }

    public function getById($id)
    {
        return Plant::with('employees')->find($id);
    }

    public function create(array $data)
    {
        return Plant::create($data);
    }

    public function update($id, array $data)
    {
        $plant = Plant::find($id);
        if ($plant) {
            $plant->update($data);
            return Plant::with('employees')->find($id);
        }
        return null;
    }

    public function delete($id)
    {
        $plant = Plant::find($id);
        if ($plant) {
            $plant->delete();
            return true;
        }
        return false;
    }
}