<?php

namespace App\Http\Controllers;

use App\Models\EvaluationAnswer;
use App\Repositories\Interfaces\IEvaluationAnswerRepository;
use Illuminate\Http\Request;

class EvaluationAnswerController extends Controller
{
    protected $evaluationAnswerRepository;

    public function __construct(IEvaluationAnswerRepository $evaluationAnswerRepository)
    {
        $this->evaluationAnswerRepository = $evaluationAnswerRepository;
    }

    public function index()
    {
        $evaluationAnswers = $this->evaluationAnswerRepository->getAll();
        return response()->json($evaluationAnswers);
    }

    public function show($id)
    {
        $evaluationAnswer = $this->evaluationAnswerRepository->getById($id);

        if (!$evaluationAnswer) {
            return response()->json(['message' => 'Evaluation Answer not found'], 404);
        }

        return response()->json($evaluationAnswer);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|exists:employees,code',
            'criteria_form_id' => 'required|integer|exists:criteria_forms,criteria_form_id',
            'total_score' => 'required|integer|min:0',
        ]);

        $evaluationAnswer = $this->evaluationAnswerRepository->create($validated);

        return response()->json($evaluationAnswer, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code' => 'sometimes|string|exists:employees,code',
            'criteria_form_id' => 'sometimes|integer|exists:criteria_forms,criteria_form_id',
            'total_score' => 'required|integer|min:0',
        ]);

        $evaluationAnswer = $this->evaluationAnswerRepository->update($id, $validated);

        if (!$evaluationAnswer) {
            return response()->json(['message' => 'Evaluation Answer not found'], 404);
        }

        return response()->json($evaluationAnswer);
    }

    public function destroy($id)
    {
        $deleted = $this->evaluationAnswerRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Evaluation Answer not found'], 404);
        }

        return response()->json(['message' => 'Evaluation Answer deleted successfully']);
    }

    // Route tùy chọn để lấy chi tiết bao gồm evaluationAnswerDetails
    public function showWithDetails($id)
    {
        $evaluationAnswer = EvaluationAnswer::with(['employee', 'criteriaForm', 'evaluationAnswerDetails'])->find($id);

        if (!$evaluationAnswer) {
            return response()->json(['message' => 'Evaluation Answer not found'], 404);
        }

        return response()->json($evaluationAnswer);
    }

}
