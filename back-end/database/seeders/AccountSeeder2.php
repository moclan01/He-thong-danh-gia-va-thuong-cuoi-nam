<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class AccountSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            //department 2
            [
                'code' => '002226',
                'username' => 'employee2',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '002507',
                'username' => 'employee3',
                'password' => Hash::make('password123'),
                'role' => 'manager',
                'status' => 'active',
            ],
            [
                'code' => '002633',
                'username' => 'employee4',
                'password' => Hash::make('password123'),
                'role' => 'supervisor',
                'status' => 'active',
            ],
            [
                'code' => '004402',
                'username' => 'employee5',
                'password' => Hash::make('password123'),
                'role' => 'hr',
                'status' => 'active',
            ],
            [
                'code' => '006087',
                'username' => 'employee6',
                'password' => Hash::make('password123'),
                'role' => 'director',
                'status' => 'active',
            ],
            [
                'code' => '012070',
                'username' => 'employee7',
                'password' => Hash::make('password123'),
                'role' => 'director',
                'status' => 'active',
            ],
            [
                'code' => '013044',
                'username' => 'employee8',
                'password' => Hash::make('password123'),
                'role' => 'director',
                'status' => 'active',
            ],
            [
                'code' => '015527',
                'username' => 'manager2',
                'password' => Hash::make('password123'),
                'role' => 'manager',
                'status' => 'active',
            ],
            [
                'code' => '016062',
                'username' => 'manager3',
                'password' => Hash::make('password123'),
                'role' => 'manager',
                'status' => 'active',
            ],
            [
                'code' => '017897',
                'username' => 'supervisor2',
                'password' => Hash::make('password123'),
                'role' => 'supervisor',
                'status' => 'active',
            ],
            

        ];

        foreach ($accounts as $account) {
            Account::create($account);
        }
    }
}
