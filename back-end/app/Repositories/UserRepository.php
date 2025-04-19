<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;

class UserRepository implements IUserRepository
{
    public function getAll()
    {
        return User::with('employee')->get();
    }

    public function getById($id)
    {
        return User::with('employee')->find($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = User::find($id);

        if (!$user) {
            return null;
        }

        if (isset($data['password'])) {
            $user->password = $data['password'];
        }

        $user->fill($data);
        $user->save();

        return $user;
    }

    public function delete($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return true;
        }

        return false;
    }
}
