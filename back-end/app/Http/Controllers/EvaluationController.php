<?php

namespace App\Http\Controllers;

use App\Models\CriteriaForm;
use App\Models\EvaluationAnswer;
use App\Models\EvaluationAnswerDetail;
use App\Models\EvaluationQuestion;
use App\Repositories\Interfaces\IEvaluationAnswerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    protected $evaluationAnswerRepository;

    public function __construct(IEvaluationAnswerRepository $evaluationAnswerRepository)
    {
        $this->evaluationAnswerRepository = $evaluationAnswerRepository;
        $this->middleware('auth:sanctum');
        $this->middleware('role:employee');
    }

    // Tham gia đánh giá
    public function participate(Request $request)
    {
        $account = Auth::user();
        $employee = $account->employee;

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $validated = $request->validate([
            'criteria_form_id' => 'required|exists:criteria_forms,criteria_form_id',
            'answers' => 'required|array',
            'answers.*.evaluation_question_id' => 'required|exists:evaluation_questions,evaluation_question_id',
            'answers.*.employee_score' => 'required|numeric|min:0',
        ]);

        $criteriaForm = CriteriaForm::find($validated['criteria_form_id']);
        if (!$criteriaForm) {
            return response()->json(['message' => 'Criteria form not found'], 404);
        }

        // Tạo EvaluationAnswer
        $evaluationAnswer = EvaluationAnswer::create([
            'code' => $employee->code,
            'criteria_form_id' => $validated['criteria_form_id'],
            'total_score' => 0, // Sẽ tính sau
        ]);

        $totalScore = 0;
        foreach ($validated['answers'] as $answer) {
            $question = EvaluationQuestion::find($answer['evaluation_question_id']);
            if (!$question) {
                continue;
            }

            $maxScore = $question->max_score;
            if ($answer['employee_score'] > $maxScore) {
                return response()->json(['message' => "Employee score for question {$question->question_name} exceeds max score {$maxScore}"], 400);
            }

            $detail = EvaluationAnswerDetail::create([
                'evaluation_question_id' => $answer['evaluation_question_id'],
                'evaluation_answer_id' => $evaluationAnswer->evaluation_answer_id,
                'employee_score' => $answer['employee_score'],
                'manager_score' => null,
                'supervisor_score' => null,
                'director_score' => null,
            ]);

            $totalScore += $detail->employee_score;
        }

        $evaluationAnswer->update(['total_score' => $totalScore]);

        return response()->json([
            'message' => 'Evaluation submitted successfully',
            'evaluation_answer' => $evaluationAnswer->load('evaluationAnswerDetails.evaluationQuestion'),
        ], 201);
    }

    // Xem kết quả đánh giá
    public function viewResult($evaluationAnswerId)
    {
        $account = Auth::user();
        $employee = $account->employee;

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $evaluationAnswer = EvaluationAnswer::where('evaluation_answer_id', $evaluationAnswerId)
            ->where('code', $employee->code)
            ->with(['criteriaForm', 'evaluationAnswerDetails.evaluationQuestion'])
            ->first();

        if (!$evaluationAnswer) {
            return response()->json(['message' => 'Evaluation answer not found or unauthorized'], 404);
        }

        $result = [];
        foreach ($evaluationAnswer->evaluationAnswerDetails as $detail) {
            $result[] = [
                'content' => $detail->evaluationQuestion->question_name, // Nội dung
                'max_score' => $detail->evaluationQuestion->max_score, // Điểm tối đa
                'employee_score' => $detail->employee_score, // Nhân viên
                'manager_score' => $detail->manager_score, // Quản lý
                'supervisor_score' => $detail->supervisor_score, // Supervisor
                'director_score' => $detail->director_score, // Director
            ];
        }

        return response()->json([
            'evaluation_answer_id' => $evaluationAnswer->evaluation_answer_id,
            'criteria_form' => $evaluationAnswer->criteriaForm->criteria_form_name,
            'total_score' => $evaluationAnswer->total_score,
            'details' => $result,
        ]);
    }

    // Xem lịch sử đánh giá
    public function viewHistory()
    {
        $account = Auth::user();
        $employee = $account->employee;

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $evaluationAnswers = EvaluationAnswer::where('code', $employee->code)
            ->with(['criteriaForm', 'evaluationAnswerDetails.evaluationQuestion'])
            ->get();

        $history = [];
        foreach ($evaluationAnswers as $evaluationAnswer) {
            $details = [];
            foreach ($evaluationAnswer->evaluationAnswerDetails as $detail) {
                $details[] = [
                    'content' => $detail->evaluationQuestion->question_name,
                    'max_score' => $detail->evaluationQuestion->max_score,
                    'employee_score' => $detail->employee_score,
                    'manager_score' => $detail->manager_score,
                    'supervisor_score' => $detail->supervisor_score,
                    'director_score' => $detail->director_score,
                ];
            }

            $history[] = [
                'evaluation_answer_id' => $evaluationAnswer->evaluation_answer_id,
                'criteria_form' => $evaluationAnswer->criteriaForm->criteria_form_name,
                'total_score' => $evaluationAnswer->total_score,
                'details' => $details,
            ];
        }

        return response()->json($history);
    }
}
