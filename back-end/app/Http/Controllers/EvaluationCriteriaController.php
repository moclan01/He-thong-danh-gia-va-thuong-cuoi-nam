<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IEvaluationCriteriaRepository;
use Illuminate\Http\Request;

class EvaluationCriteriaController extends Controller
{
    protected $evaluationCriteriaRepository;

    public function __construct(IEvaluationCriteriaRepository $evaluationCriteriaRepository)
    {
        $this->evaluationCriteriaRepository = $evaluationCriteriaRepository;
    }

    public function index()
    {
        $evaluationCriteria = $this->evaluationCriteriaRepository->getAll();
        return response()->json($evaluationCriteria);
    }

    public function show($id)
    {
        $evaluationCriteria = $this->evaluationCriteriaRepository->getById($id);

        if (!$evaluationCriteria) {
            return response()->json(['message' => 'Evaluation Criteria not found'], 404);
        }

        return response()->json($evaluationCriteria);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'criteria_name' => 'required|string|max:255',
        ]);

        $evaluationCriteria = $this->evaluationCriteriaRepository->create($validated);

        return response()->json($evaluationCriteria, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'criteria_name' => 'required|string|max:255',
        ]);

        $evaluationCriteria = $this->evaluationCriteriaRepository->update($id, $validated);

        if (!$evaluationCriteria) {
            return response()->json(['message' => 'Evaluation Criteria not found'], 404);
        }

        return response()->json($evaluationCriteria);
    }

    public function destroy($id)
    {
        $deleted = $this->evaluationCriteriaRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Evaluation Criteria not found'], 404);
        }

        return response()->json(['message' => 'Evaluation Criteria deleted successfully']);
    }
}
