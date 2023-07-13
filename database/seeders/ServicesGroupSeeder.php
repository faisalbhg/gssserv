<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ServicesGroups;

class ServicesGroupSeeder extends Seeder
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
            ['service_group_name'=>'General Service','service_group_code'=>'GS', 'service_group_description' => 'General Service','department_id'=>2,'section_id'=>1,'station_id'=>3],
            ['service_group_name'=>'General Lube','service_group_code'=>'QL', 'service_group_description' => 'General Lube','department_id'=>2,'section_id'=>2,'station_id'=>3],
            ['service_group_name'=>'General Wash','service_group_code'=>'QW', 'service_group_description' => 'General Wash','department_id'=>2,'section_id'=>3,'station_id'=>3],
        ];

        foreach ($datas as $data) {
            ServicesGroups::create($data);
        }
    }
}
