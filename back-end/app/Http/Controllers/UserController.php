<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAll();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = $this->userRepository->getById($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|unique:users',
            'code' => 'required|string|exists:employees,code|unique:users,code',
            'password' => 'required|string|min:6',
            'status' => 'required|boolean',
            'role' => 'required|string',
        ]);

        $user = $this->userRepository->create($validatedData);
        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'username' => 'nullable|string|unique:users,username,' . $id,
            'password' => 'nullable|string|min:6',
            'status' => 'nullable|boolean',
            'role' => 'nullable|string',
        ]);

        $user = $this->userRepository->update($id, $validatedData);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function destroy($id)
    {
        $deleted = $this->userRepository->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['message' => 'User deleted successfully']);
    }
}
