<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EvaluationCycle;
use App\Repositories\Interfaces\IEvaluationCycleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EvaluationCycleController extends Controller
{
    protected $evaluationCycleRepository;

    public function __construct(IEvaluationCycleRepository $evaluationCycleRepository)
    {
        $this->evaluationCycleRepository = $evaluationCycleRepository;
    }

    public function index()
    {
        $evaluationCycles = $this->evaluationCycleRepository->getAll();
        return response()->json($evaluationCycles);
    }

    public function show($id)
    {
        $evaluationCycle = $this->evaluationCycleRepository->getById($id);

        if (!$evaluationCycle) {
            return response()->json(['message' => 'Evaluation Cycle not found'], 404);
        }

        return response()->json($evaluationCycle);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cycle_name' => 'required|string|max:255',
            'department_id' => 'nullable|integer|exists:departments,department_id',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|in:open,closed,pending',
        ]);

        $evaluationCycle = $this->evaluationCycleRepository->create($validated);

        return response()->json($evaluationCycle, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'cycle_name' => 'required|string|max:255',
            'department_id' => 'nullable|integer|exists:departments,department_id',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|in:open,closed,pending',
        ]);

        $evaluationCycle = $this->evaluationCycleRepository->update($id, $validated);

        if (!$evaluationCycle) {
            return response()->json(['message' => 'Evaluation Cycle not found'], 404);
        }

        return response()->json($evaluationCycle);
    }

    public function destroy($id)
    {
        $deleted = $this->evaluationCycleRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Evaluation Cycle not found'], 404);
        }

        return response()->json(['message' => 'Evaluation Cycle deleted successfully']);
    }

    
}
