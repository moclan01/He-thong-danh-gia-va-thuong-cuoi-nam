<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IEvaluationCycleRepository;
use Illuminate\Http\Request;

class EvaluationCycleController extends Controller
{
    protected $repository;

    public function __construct(IEvaluationCycleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return response()->json($this->repository->getAll());
    }

    public function show($id)
    {
        $cycle = $this->repository->getById($id);
        if (!$cycle) {
            return response()->json(['message' => 'Evaluation cycle not found'], 404);
        }
        return response()->json($cycle);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cycles_id'     => 'required|string|unique:evaluation_cycles',
            'department_id' => 'required|string|exists:departments,department_id',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'status'        => 'required|boolean',
        ]);

        $cycle = $this->repository->create($validated);
        return response()->json($cycle, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'department_id' => 'sometimes|required|string|exists:departments,department_id',
            'start_date'    => 'sometimes|required|date',
            'end_date'      => 'sometimes|required|date|after_or_equal:start_date',
            'status'        => 'sometimes|required|boolean',
        ]);

        $cycle = $this->repository->update($id, $validated);
        if (!$cycle) {
            return response()->json(['message' => 'Evaluation cycle not found'], 404);
        }

        return response()->json($cycle);
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'Evaluation cycle not found'], 404);
        }
        return response()->json(['message' => 'Deleted successfully']);
    }
}
