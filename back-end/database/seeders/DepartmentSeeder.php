<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['department_name' => 'Admin & General Affair', 'manage_code' => null, 'vp_group' => 'HR&HSE&ADMIN'],
            ['department_name' => 'HSE', 'manage_code' => null, 'vp_group' => 'HR&HSE&ADMIN'],
            ['department_name' => 'Human Resource', 'manage_code' => null, 'vp_group' => 'HR&HSE&ADMIN'],
            ['department_name' => 'Creative', 'manage_code' => null, 'vp_group' => 'SALES & COMMERCIAL'],
            ['department_name' => 'Customer Service', 'manage_code' => null, 'vp_group' => 'SALES & COMMERCIAL'],
            ['department_name' => 'Demand Planning', 'manage_code' => null, 'vp_group' => 'SALES & COMMERCIAL'],
            ['department_name' => 'Product Development', 'manage_code' => null, 'vp_group' => 'SALES & COMMERCIAL'],
            ['department_name' => 'Sales', 'manage_code' => null, 'vp_group' => 'SALES & COMMERCIAL'],
            ['department_name' => 'Engineering', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Facility Management', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'General Management', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Casegoods Finishing', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Casegoods Whitewood', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Lean Manufacturing', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Process Engineering', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Material Warehouse', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Metal Work', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Production Finishing Support', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Production Management', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Production Planning', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Prototype Shop', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Quality', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'R&D', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Standard Costing', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Supply Chain & Outsourcing', 'manage_code' => null, 'vp_group' => 'OPERATIONS'],
            ['department_name' => 'Finance', 'manage_code' => null, 'vp_group' => 'FINANCE & IT'],
            ['department_name' => 'Information Technology', 'manage_code' => null, 'vp_group' => 'FINANCE & IT'],
            ['department_name' => 'Upholstery', 'manage_code' => null, 'vp_group' => 'UPHOLSTERY'],
        ];

        DB::table('departments')->insert($departments);
    }
}
