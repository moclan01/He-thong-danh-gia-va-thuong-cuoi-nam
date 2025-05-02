<?php

namespace App\Http\Controllers;

use App\Models\EvaluationQuestion;
use App\Repositories\Interfaces\IEvaluationQuestionRepository;
use Illuminate\Http\Request;

class EvaluationQuestionController extends Controller
{
    protected $evaluationQuestionRepository;

    public function __construct(IEvaluationQuestionRepository $evaluationQuestionRepository)
    {
        $this->evaluationQuestionRepository = $evaluationQuestionRepository;
    }

    public function index()
    {
        $evaluationQuestions = $this->evaluationQuestionRepository->getAll();
        return response()->json($evaluationQuestions);
    }

    public function show($id)
    {
        $evaluationQuestion = $this->evaluationQuestionRepository->getById($id);

        if (!$evaluationQuestion) {
            return response()->json(['message' => 'Evaluation Question not found'], 404);
        }

        return response()->json($evaluationQuestion);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'evaluation_criteria_id' => 'required|integer|exists:evaluation_criteria,evaluation_criteria_id',
            'question_name' => 'required|string|max:255',
            'max_score' => 'required|integer|min:1',
        ]);

        $evaluationQuestion = $this->evaluationQuestionRepository->create($validated);

        return response()->json($evaluationQuestion, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'evaluation_criteria_id' => 'sometimes|integer|exists:evaluation_criteria,evaluation_criteria_id',
            'question_name' => 'required|string|max:255',
            'max_score' => 'required|integer|min:1',
        ]);

        $evaluationQuestion = $this->evaluationQuestionRepository->update($id, $validated);

        if (!$evaluationQuestion) {
            return response()->json(['message' => 'Evaluation Question not found'], 404);
        }

        return response()->json($evaluationQuestion);
    }

    public function destroy($id)
    {
        $deleted = $this->evaluationQuestionRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Evaluation Question not found'], 404);
        }

        return response()->json(['message' => 'Evaluation Question deleted successfully']);
    }

    public function showWithDetails($id)
    {
        $evaluationQuestion = EvaluationQuestion::with(['evaluationCriteria', 'evaluationAnswerDetails'])->find($id);

        if (!$evaluationQuestion) {
            return response()->json(['message' => 'Evaluation Question not found'], 404);
        }

        return response()->json($evaluationQuestion);
    }
}
