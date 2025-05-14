<?php

namespace App\Http\Controllers;

use App\Models\CriteriaForm;
use App\Models\EvaluationCriteria;
use App\Repositories\Interfaces\ICriteriaFormRepository;
use Illuminate\Http\Request;

class CriteriaFormController extends Controller
{
    protected $criteriaFormRepository;

    public function __construct(ICriteriaFormRepository $criteriaFormRepository)
    {
        $this->criteriaFormRepository = $criteriaFormRepository;
    }

    public function index()
    {
        $criteriaForms = $this->criteriaFormRepository->getAll();
        return response()->json($criteriaForms);
    }

    public function show($id)
    {
        $criteriaForm = $this->criteriaFormRepository->getById($id);

        if (!$criteriaForm) {
            return response()->json(['message' => 'Criteria Form not found'], 404);
        }

        return response()->json($criteriaForm);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'evaluation_cycle_id' => 'required|integer|exists:evaluation_cycles,evaluation_cycle_id',
            'criteria_form_name' => 'required|string|max:255',
        ]);

        $criteriaForm = $this->criteriaFormRepository->create($validated);

        return response()->json($criteriaForm, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'evaluation_cycle_id' => 'sometimes|integer|exists:evaluation_cycles,evaluation_cycle_id',
            'criteria_form_name' => 'required|string|max:255',
        ]);

        $criteriaForm = $this->criteriaFormRepository->update($id, $validated);

        if (!$criteriaForm) {
            return response()->json(['message' => 'Criteria Form not found'], 404);
        }

        return response()->json($criteriaForm);
    }

    public function destroy($id)
    {
        $deleted = $this->criteriaFormRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Criteria Form not found'], 404);
        }

        return response()->json(['message' => 'Criteria Form deleted successfully']);
    }

    public function getCriteriaList($id)
    {
        $criteriaForm = CriteriaForm::with('evaluationCriteria')->find($id);

        if (!$criteriaForm) {
            return response()->json(['message' => 'Criteria Form not found'], 404);
        }

        return response()->json($criteriaForm->evaluationCriteria);
    }

    public function addCriteriaToForm(Request $request, $formId)
    {
        $validated = $request->validate([
            'evaluation_criteria_id' => 'required|integer|exists:evaluation_criterias,evaluation_criteria_id',
        ]);

        $criteriaForm = CriteriaForm::find($formId);

        if (!$criteriaForm) {
            return response()->json(['message' => 'Criteria Form not found'], 404);
        }

        $criteria = EvaluationCriteria::find($validated['evaluation_criteria_id']);

        if (!$criteria) {
            return response()->json(['message' => 'Evaluation Criteria not found'], 404);
        }

        if ($criteriaForm->evaluationCriteria->contains($criteria)) {
            return response()->json(['message' => 'Criteria already exists in this form'], 400);
        }

        $criteriaForm->evaluationCriteria()->attach($criteria);

        return response()->json(['message' => 'Criteria added to form successfully']);
    }

}
