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
                'code' => '3870',
                'fullname' => 'ĐÀM THANH HUÂN',
                'plant_id' => null,
                'department_id' => null,
                'position_id' => null,
                'code_r' => null,
                'division' => 'RSC',
                'basic' => '16834000',
                'grade' => 'TE',
                'stafftype' => '3',
                'start_date' => '2010-06-08',
                'type' => 'DL',
            ],
            [
                'code' => '3979',
                'fullname' => 'NGUYỄN THỊ LAN ANH',
                'plant_id' => null,
                'department_id' => null,
                'position_id' => null,
                'code_r' => null,
                'division' => 'RSC',
                'basic' => '64010000',
                'grade' => 'MM',
                'stafftype' => '1',
                'start_date' => '2010-07-01',
                'type' => 'IDL',
            ],
            [
                'code' => '4639',
                'fullname' => 'TRẦN XUÂN MẠNH',
                'plant_id' => null,
                'department_id' => null,
                'position_id' => null,
                'code_r' => null,
                'division' => 'RSC',
                'basic' => '15183000',
                'grade' => 'TE',
                'stafftype' => '3',
                'start_date' => '2010-09-09',
                'type' => 'DL',
            ],
            [
                'code' => '6330',
                'fullname' => 'KIM THỊ HƯỜNG',
                'plant_id' => null,
                'department_id' => null,
                'position_id' => null,
                'code_r' => null,
                'division' => 'RSC',
                'basic' => '12268000',
                'grade' => 'TE',
                'stafftype' => '3',
                'start_date' => '2012-02-06',
                'type' => 'DL',
            ],
            [
                'code' => '6851',
                'fullname' => 'PHAN VĂN ĐẠI',
                'plant_id' => null,
                'department_id' => null,
                'position_id' => null,
                'code_r' => null,
                'division' => 'RSC',
                'basic' => '15488000',
                'grade' => 'TE',
                'stafftype' => '3',
                'start_date' => '2012-04-26',
                'type' => 'DL',
            ]
        ]);
    }
}
