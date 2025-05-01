<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IAccountRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    protected $accountRepository;

    public function __construct(IAccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function index()
    {
        $accounts = $this->accountRepository->getAll();
        return response()->json($accounts);
    }

    public function show($id)
    {
        $account = $this->accountRepository->getById($id);

        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        return response()->json($account);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:accounts,code|exists:employees,code',
            'username' => 'required|string|unique:accounts,username|max:255',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:admin,manager,employee',
            'status' => 'required|string|in:active,inactive',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $account = $this->accountRepository->create($validated);

        return response()->json($account, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code' => 'sometimes|string|unique:accounts,code,' . $id . '|exists:employees,code',
            'username' => 'sometimes|string|unique:accounts,username,' . $id . '|max:255',
            'password' => 'sometimes|string|min:6',
            'role' => 'sometimes|string|in:admin,manager,employee',
            'status' => 'sometimes|string|in:active,inactive',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $account = $this->accountRepository->update($id, $validated);

        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        return response()->json($account);
    }

    public function destroy($id)
    {
        $deleted = $this->accountRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        return response()->json(['message' => 'Account deleted successfully']);
    }
}
