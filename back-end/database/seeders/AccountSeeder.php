<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            [
                'code' => '006330',
                'username' => 'employee1',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '014106',
                'username' => 'manager1',
                'password' => Hash::make('password123'),
                'role' => 'manager',
                'status' => 'active',
            ],
            [
                'code' => '018252',
                'username' => 'supervisor1',
                'password' => Hash::make('password123'),
                'role' => 'supervisor',
                'status' => 'active',
            ],
            [
                'code' => '019264',
                'username' => 'hr1',
                'password' => Hash::make('  '),
                'role' => 'hr',
                'status' => 'active',
            ],
            [
                'code' => '036071',
                'username' => 'director1',
                'password' => Hash::make('password123'),
                'role' => 'director',
                'status' => 'active',
            ],
        ];

        foreach ($accounts as $account) {
            Account::create($account);
        }
    }
}
