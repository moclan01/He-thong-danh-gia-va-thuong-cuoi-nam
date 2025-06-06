<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IWhatFormRepository;
use Illuminate\Http\Request;

class WhatFormController extends Controller
{
    protected $whatFormRepo;

    public function __construct(IWhatFormRepository $whatFormRepo)
    {
        $this->whatFormRepo = $whatFormRepo;
    }

    public function index()
    {
        return response()->json($this->whatFormRepo->getAll());
    }

    public function show($id)
    {
        return response()->json($this->whatFormRepo->getById($id));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->whatFormRepo->create($data));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $updated = $this->whatFormRepo->update($id, $data);
        return response()->json($updated);
    }

    public function destroy($id)
    {
        $deleted = $this->whatFormRepo->delete($id);
        return response()->json(['deleted' => $deleted]);
    }
}
