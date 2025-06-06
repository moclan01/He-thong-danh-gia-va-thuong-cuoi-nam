<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IPersonalDevelopmentFormRepository;
use Illuminate\Http\Request;

class PersonalDevelopmentFormController extends Controller
{
    protected $repo;

    public function __construct(IPersonalDevelopmentFormRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return response()->json($this->repo->getAll());
    }

    public function show($id)
    {
        return response()->json($this->repo->getById($id));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->repo->create($data));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $updated = $this->repo->update($id, $data);
        return response()->json($updated);
    }

    public function destroy($id)
    {
        $deleted = $this->repo->delete($id);
        return response()->json(['deleted' => $deleted]);
    }
}
