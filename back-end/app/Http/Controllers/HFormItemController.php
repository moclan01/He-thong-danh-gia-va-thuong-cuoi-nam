<?php

namespace App\Http\Controllers;

use App\Models\HformItem;
use App\Repositories\Interfaces\IHFormItemRepository;
use Illuminate\Http\Request;

class HFormItemController extends Controller
{
    protected $repository;

    public function __construct(IHFormItemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return response()->json($this->repository->getAll());
    }

    public function show($id)
    {
        return response()->json($this->repository->getById($id));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $fields = ['target', 'actual', 'FY_target', 'm', 'n'];
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $data[$field] = $data[$field] / 100;
            }
        }

        $data['threshold'] = FunctionController::calculateThreshold($data['target'], $data['m']);
        $data['stretch'] = FunctionController::calculateStretch($data['target'], $data['n']);


        $data['score'] = FunctionController::calculateScore(
            $data['stretch'],
            $data['target'],
            $data['threshold'],
            $data['actual'] ?? 0
        );

        $result = $this->repository->create($data);

        return response()->json($result, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $fields = ['target', 'actual', 'FY_target', 'm', 'n'];
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $data[$field] = $data[$field] / 100;
            }
        }

        if (isset($data['target'], $data['m'])) {
            $data['threshold'] = FunctionController::calculateThreshold($data['target'], $data['m']);
        }
        if (isset($data['target'], $data['n'])) {
            $data['stretch'] = FunctionController::calculateStretch($data['target'], $data['n']);
        }


        $item = $this->repository->getById($id);

        $stretch = $data['stretch'] ?? $item->stretch;
        $target = $data['target'] ?? $item->target;
        $threshold = $data['threshold'] ?? $item->threshold;
        $actual = $data['actual'] ?? $item->actual ?? 0;

        $data['score'] = FunctionController::calculateScore($stretch, $target, $threshold, $actual);

        $result = $this->repository->update($id, $data);

        return response()->json($result);
    }

    public function destroy($id)
    {
        $success = $this->repository->delete($id);
        return response()->json(['success' => $success]);
    }

    public function getByHowForm($how_form_id)
    {
        return response()->json($this->repository->getByHowForm($how_form_id));
    }
}
