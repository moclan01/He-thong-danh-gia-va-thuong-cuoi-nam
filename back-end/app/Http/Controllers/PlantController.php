<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IPlantRepository;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    protected $plantRepository;
    public function __construct(IPlantRepository $plantRepository)
    {
        $this->plantRepository = $plantRepository;
    }

    public function index()
    {
        return response()->json($this->plantRepository->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plant_id' => 'required|string|unique:plants,plant_id',
            'plant_name' => 'required|string|max:255',
        ]);

        $plant = $this->plantRepository->create($validated);
        return response()->json(['message' => 'Plant created successfully!', 'data' => $plant], 201);
    }

    public function show($id)
    {
        $plant = $this->plantRepository->getById($id);
        if (!$plant) {
            return response()->json(['message' => 'Plant not found!'], 404);
        }
        return response()->json($plant);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'plant_name' => 'required|string|max:255',
        ]);

        $plant = $this->plantRepository->update($id, $validated);
        if (!$plant) {
            return response()->json(['message' => 'Plant not found!'], 404);
        }

        return response()->json(['message' => 'Plant updated successfully!', 'data' => $plant]);
    }

    public function destroy($id)
    {
        $deleted = $this->plantRepository->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'Plant not found!'], 404);
        }

        return response()->json(['message' => 'Plant deleted successfully!']);
    }
}
