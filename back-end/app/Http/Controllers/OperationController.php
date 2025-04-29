<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IOperationRepository;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    protected $operationRepository;

    public function __construct(IOperationRepository $operationRepository)
    {
        $this->operationRepository = $operationRepository;
    }

    public function index()
    {
        return response()->json($this->operationRepository->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'nullable|integer|exists:departments,department_id',
            'operation_name' => 'required|string|max:255',
        ]);

        $operation = $this->operationRepository->create($validated);
        return response()->json($operation, 201);
    }

    public function show($id)
    {
        $operation = $this->operationRepository->getById($id);
        if (!$operation) {
            return response()->json(['message' => 'Operation not found'], 404);
        }
        return response()->json($operation);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'department_id' => 'nullable|integer|exists:departments,department_id',
            'operation_name' => 'required|string|max:255',
        ]);

        $operation = $this->operationRepository->update($id, $validated);
        if (!$operation) {
            return response()->json(['message' => 'Operation not found'], 404);
        }

        return response()->json($operation);
    }

    public function destroy($id)
    {
        $deleted = $this->operationRepository->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'Operation not found'], 404);
        }
        return response()->json(['message' => 'Operation deleted successfully']);
    }
}
