<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = 
        [
            ['department_name'=>'IT','department_description'=>'IT'],
            ['department_name'=>'Operation','department_description'=>'Operation'],
            ['department_name'=>'Sales','department_description'=>'Sales'],
            ['department_name'=>'Finance','department_description'=>'Finance'],
            ['department_name'=>'Customer Care','department_description'=>'Customer Care'],
        ];

        foreach ($datas as $data) {
            Department::create($data);
        }
    }
}
