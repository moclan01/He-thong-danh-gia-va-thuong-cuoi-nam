<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IHowFormRepository;
use Illuminate\Http\Request;

class HowFormController extends Controller
{
    protected $repository;

    public function __construct(IHowFormRepository $repository)
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
        $result = $this->repository->create($data);
        return response()->json($result, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $result = $this->repository->update($id, $data);
        return response()->json($result);
    }

    public function destroy($id)
    {
        $success = $this->repository->delete($id);
        return response()->json(['success' => $success]);
    }
}
