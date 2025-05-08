<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IEvaluationAnswerDetailRepository;
use Illuminate\Http\Request;

class EvaluationAnswerDetailController extends Controller
{
    protected $evaluationAnswerDetailRepository;

    public function __construct(IEvaluationAnswerDetailRepository $evaluationAnswerDetailRepository)
    {
        $this->evaluationAnswerDetailRepository = $evaluationAnswerDetailRepository;
    }

    public function index()
    {
        $evaluationAnswerDetails = $this->evaluationAnswerDetailRepository->getAll();
        return response()->json($evaluationAnswerDetails);
    }

    public function show($id)
    {
        $evaluationAnswerDetail = $this->evaluationAnswerDetailRepository->getById($id);

        if (!$evaluationAnswerDetail) {
            return response()->json(['message' => 'Evaluation Answer Detail not found'], 404);
        }

        return response()->json($evaluationAnswerDetail);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'evaluation_question_id' => 'required|integer|exists:evaluation_questions,evaluation_question_id',
            'evaluation_answer_id' => 'required|integer|exists:evaluation_answers,evaluation_answer_id',
            'score' => 'required|integer|min:0|max:100', // Giả định điểm số trong khoảng 0-100
        ]);

        $evaluationAnswerDetail = $this->evaluationAnswerDetailRepository->create($validated);

        return response()->json($evaluationAnswerDetail, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'evaluation_question_id' => 'sometimes|integer|exists:evaluation_questions,evaluation_question_id',
            'evaluation_answer_id' => 'sometimes|integer|exists:evaluation_answers,evaluation_answer_id',
            'score' => 'required|integer|min:0|max:120',
        ]);

        $evaluationAnswerDetail = $this->evaluationAnswerDetailRepository->update($id, $validated);

        if (!$evaluationAnswerDetail) {
            return response()->json(['message' => 'Evaluation Answer Detail not found'], 404);
        }

        return response()->json($evaluationAnswerDetail);
    }

    public function destroy($id)
    {
        $deleted = $this->evaluationAnswerDetailRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Evaluation Answer Detail not found'], 404);
        }

        return response()->json(['message' => 'Evaluation Answer Detail deleted successfully']);
    }
}
