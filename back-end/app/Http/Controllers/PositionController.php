<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IPositionRepository;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    protected $positionRepository;

    public function __construct(IPositionRepository
     $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }

    public function index()
    {
        return response()->json($this->positionRepository->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'operation_id' => 'nullable|integer|exists:operations,operation_id',
            'position_name' => 'required|string|max:255',
        ]);

        $position = $this->positionRepository->create($validated);
        return response()->json($position, 201);
    }

    public function show($id)
    {
        $position = $this->positionRepository->getById($id);
        if (!$position) {
            return response()->json(['message' => 'Position not found'], 404);
        }
        return response()->json($position);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'operation_id' => 'nullable|integer|exists:operations,operation_id',
            'position_name' => 'required|string|max:255',
        ]);

        $position = $this->positionRepository->update($id, $validated);
        if (!$position) {
            return response()->json(['message' => 'Position not found'], 404);
        }

        return response()->json($position);
    }

    public function destroy($id)
    {
        $deleted = $this->positionRepository->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'Position not found'], 404);
        }
        return response()->json(['message' => 'Position deleted successfully']);
    }
}
