<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountSeeder3 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $accounts = [
            
            [
                'code' => '043565',
                'username' => 'employee3_!',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '043458',
                'username' => 'employee3_2',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '043164',
                'username' => 'employee3_3',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '038807',
                'username' => 'employee3_4',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '037898',
                'username' => 'employee3_5',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '037812',
                'username' => 'employee3_6',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '037402',
                'username' => 'employee3_7',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'status' => 'active',
            ],
            [
                'code' => '034869',
                'username' => 'manager3_1',
                'password' => Hash::make('password123'),
                'role' => 'manager',
                'status' => 'active',
            ],
            [
                'code' => '033762',
                'username' => 'manager3_2',
                'password' => Hash::make('password123'),
                'role' => 'manager',
                'status' => 'active',
            ],
            [
                'code' => '017897',
                'username' => 'supervisor2_1',
                'password' => Hash::make('password123'),
                'role' => 'supervisor',
                'status' => 'active',
            ],
             [
                'code' => '031495',
                'username' => 'supervisor3_1',
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
