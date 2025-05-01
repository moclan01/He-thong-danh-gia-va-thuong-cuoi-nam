<?php

namespace App\Repositories;

use App\Models\Account;
use App\Repositories\Interfaces\IAccountRepository;

class AccountRepository implements IAccountRepository{
    public function getAll()
    {
        return Account::with('employee')->get();
    }

    public function getById($id)
    {
        return Account::with('employee')->find($id);
    }

    public function create(array $data)
    {
        return Account::create($data);
    }

    public function update($id, array $data)
    {
        $account = Account::find($id);

        if (!$account) {
            return null;
        }

        $account->update($data);

        return $account;
    }

    public function delete($id)
    {
        $account = Account::find($id);

        if ($account) {
            $account->delete();
            return true;
        }

        return false;
    }
}