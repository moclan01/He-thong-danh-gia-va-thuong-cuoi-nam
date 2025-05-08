<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'code' => 'EMP001',
                'plant_id' => 1,
                'department_id' => 12,
                'position_id' => 1,
                'code_r' => null,
                'fullname' => 'Nguyen Van A',
                'division' => 'Sản xuất',
                'basic' => '10000000',
                'grade' => 'G1',
                'stafftype' => 'Chính thức',
                'start_date' => Carbon::parse('2023-01-01'),
                'type' => 'Full-time',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'EMP002',
                'plant_id' => 1,
                'department_id' => 12,
                'position_id' => 1,
                'code_r' => 'EMP001',
                'fullname' => 'Tran Thi B',
                'division' => 'Chất lượng',
                'basic' => '9500000',
                'grade' => 'G2',
                'stafftype' => 'Chính thức',
                'start_date' => Carbon::parse('2023-03-15'),
                'type' => 'Full-time',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
