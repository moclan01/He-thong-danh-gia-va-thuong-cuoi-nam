<?php

namespace Database\Seeders;

use App\Models\Account;
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
                'code' => '018037',
                'username' => 'employee1_2',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '019219',
                'username' => 'employee1_3',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '021445',
                'username' => 'employee1_4',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '041009',
                'username' => 'employee1_5',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '043570',
                'username' => 'employee1_6',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '043870',
                'username' => 'employee1_7',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '044084',
                'username' => 'manager1_2',
                'password' => Hash::make('password123'),
                'role' => 'manager',
                'status' => 'active',
            ],
        ];

        foreach ($accounts as $account) {
            Account::create($account);
        }
    }
}
