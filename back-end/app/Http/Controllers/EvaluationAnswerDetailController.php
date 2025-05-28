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
            'employee_score' => 'nullable|integer|min:0|max:120',
            'manager_score' => 'nullable|integer|min:0|max:120',
            'supervisor_score' => 'nullable|integer|min:0|max:120',
            'director_score' => 'nullable|integer|min:0|max:120',
        ]);

        $evaluationAnswerDetail = $this->evaluationAnswerDetailRepository->create($validated);

        return response()->json($evaluationAnswerDetail, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'employee_score' => 'nullable|integer|min:0|max:120',
            'manager_score' => 'nullable|integer|min:0|max:120',
            'supervisor_score' => 'nullable|integer|min:0|max:120',
            'director_score' => 'nullable|integer|min:0|max:120',
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

    public function storeByEmployee(Request $request)
    {
        $validated = $request->validate([
            'evaluation_question_id' => 'required|integer|exists:evaluation_questions,evaluation_question_id',
            'evaluation_answer_id' => 'required|integer|exists:evaluation_answers,evaluation_answer_id',
            'employee_score' => 'required|integer|min:0|max:120',
            'employee_comment' => 'nullable|string|max:1000',
        ]);

        $evaluationAnswerDetail = $this->evaluationAnswerDetailRepository->create($validated);

        return response()->json($evaluationAnswerDetail, 201);
    }
    public function updateManagerScore(Request $request, $id)
    {
        $validated = $request->validate([
            'manager_score' => 'required|integer|min:0|max:120',
        ]);

        $evaluationAnswerDetail = $this->evaluationAnswerDetailRepository->update($id, $validated);

        if (!$evaluationAnswerDetail) {
            return response()->json(['message' => 'Evaluation Answer Detail not found'], 404);
        }

        return response()->json($evaluationAnswerDetail);
    }
    public function updateSupervisorScore(Request $request, $id)
    {
        $validated = $request->validate([
            'supervisor_score' => 'required|integer|min:0|max:120',
            'supervisor_comment' => 'nullable|string|max:1000',
        ]);

        $evaluationAnswerDetail = $this->evaluationAnswerDetailRepository->update($id, $validated);

        if (!$evaluationAnswerDetail) {
            return response()->json(['message' => 'Evaluation Answer Detail not found'], 404);
        }

        return response()->json($evaluationAnswerDetail);
    }

    public function storeByEmployeeBatch(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.*.evaluation_question_id' => 'required|integer|exists:evaluation_questions,evaluation_question_id',
            'data.*.evaluation_answer_id' => 'required|integer|exists:evaluation_answers,evaluation_answer_id',
            'data.*.employee_score' => 'required|integer|min:0|max:120',
        ]);

        $created = [];

        foreach ($validated['data'] as $item) {
            $created[] = $this->evaluationAnswerDetailRepository->create($item);
        }

        return response()->json($created, 201);
    }

    public function updateManagerScoresBatch(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.*.evaluation_answer_detail_id' => 'required|integer|exists:evaluation_answer_details,evaluation_answer_detail_id',
            'data.*.manager_score' => 'required|integer|min:0|max:120',
        ]);

        $updated = [];

        foreach ($validated['data'] as $item) {
            $updated[] = $this->evaluationAnswerDetailRepository->update($item['evaluation_answer_detail_id'], [
                'manager_score' => $item['manager_score'],
            ]);
        }

        return response()->json($updated);
    }
    public function updateSupervisorScoresBatch(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.*.evaluation_answer_detail_id' => 'required|integer|exists:evaluation_answer_details,evaluation_answer_detail_id',
            'data.*.supervisor_score' => 'required|integer|min:0|max:120',
        ]);

        $updated = [];

        foreach ($validated['data'] as $item) {
            $updated[] = $this->evaluationAnswerDetailRepository->update($item['evaluation_answer_detail_id'], [
                'supervisor_score' => $item['supervisor_score'],
            ]);
        }

        return response()->json($updated);
    }

    public function updateEmployeeScoresBatch(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.*.evaluation_answer_detail_id' => 'required|integer|exists:evaluation_answer_details,evaluation_answer_detail_id',
            'data.*.employee_score' => 'required|integer|min:0|max:120',
        ]);

        $updated = [];

        foreach ($validated['data'] as $item) {
            $updated[] = $this->evaluationAnswerDetailRepository->update(
                $item['evaluation_answer_detail_id'],
                ['employee_score' => $item['employee_score']]
            );
        }

        return response()->json($updated);
    }

    public function updateEmployeeCommentsBatch(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.*.evaluation_answer_detail_id' => 'required|integer|exists:evaluation_answer_details,evaluation_answer_detail_id',
            'data.*.employee_comment' => 'nullable|string|max:1000',
        ]);

        $updated = [];

        foreach ($validated['data'] as $item) {
            $updated[] = $this->evaluationAnswerDetailRepository->update(
                $item['evaluation_answer_detail_id'],
                ['employee_comment' => $item['employee_comment']]
            );
        }

        return response()->json($updated);
    }

    public function updateSupervisorCommentsBatch(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.*.evaluation_answer_detail_id' => 'required|integer|exists:evaluation_answer_details,evaluation_answer_detail_id',
            'data.*.supervisor_comment' => 'nullable|string|max:1000',
        ]);

        $updated = [];

        foreach ($validated['data'] as $item) {
            $updated[] = $this->evaluationAnswerDetailRepository->update(
                $item['evaluation_answer_detail_id'],
                ['supervisor_comment' => $item['supervisor_comment']]
            );
        }

        return response()->json($updated);
    }
}
