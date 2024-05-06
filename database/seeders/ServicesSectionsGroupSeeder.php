<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ServicesSectionsGroup;

class ServicesSectionsGroupSeeder extends Seeder
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
            [
                'service_section_group_name'=>'Foam Wash',
                'service_section_group_code'=>'G301001',
                'service_section_group_description'=>'Foam Wash',
                'service_group_id'=>8,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Express Polish',
                'service_section_group_code'=>'G301002',
                'service_section_group_description'=>'Express Polish',
                'service_group_id'=>8,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Top Wash',
                'service_section_group_code'=>'G301003',
                'service_section_group_description'=>'G301003',
                'service_group_id'=>8,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Super Wash',
                'service_section_group_code'=>'G301004',
                'service_section_group_description'=>'Super Wash',
                'service_group_id'=>8,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'EXPRESS WASH',
                'service_section_group_code'=>'G301005',
                'service_section_group_description'=>'EXPRESS WASH',
                'service_group_id'=>8,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'BODY STEAM WASH',
                'service_section_group_code'=>'G301006',
                'service_section_group_description'=>'BODY STEAM WASH',
                'service_group_id'=>4,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Wash & Wax',
                'service_section_group_code'=>'G301007',
                'service_section_group_description'=>'Wash & Wax',
                'service_group_id'=>8,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'VIP Wash',
                'service_section_group_code'=>'G301008',
                'service_section_group_description'=>'VIP Wash',
                'service_group_id'=>8,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'City Wash',
                'service_section_group_code'=>'G301009',
                'service_section_group_description'=>'City Wash',
                'service_group_id'=>8,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Full Service',
                'service_section_group_code'=>'G302001',
                'service_section_group_description'=>'Full Service',
                'service_group_id'=>4,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Electrical',
                'service_section_group_code'=>'G302002',
                'service_section_group_description'=>'Electrical',
                'service_group_id'=>4,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Mechanical',
                'service_section_group_code'=>'G302003',
                'service_section_group_description'=>'Mechanical',
                'service_group_id'=>4,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Glazing',
                'service_section_group_code'=>'G302004',
                'service_section_group_description'=>'Glazing',
                'service_group_id'=>4,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Rust Proofing',
                'service_section_group_code'=>'G302005',
                'service_section_group_description'=>'Rust Proofing',
                'service_group_id'=>4,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Misc Sales',
                'service_section_group_code'=>'G302006',
                'service_section_group_description'=>'Misc Sales',
                'service_group_id'=>4,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Seat Cleaning',
                'service_section_group_code'=>'G302007',
                'service_section_group_description'=>'Seat Cleaning',
                'service_group_id'=>4,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Tinting',
                'service_section_group_code'=>'G302008',
                'service_section_group_description'=>'Tinting',
                'service_group_id'=>4,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Paint Protection Film',
                'service_section_group_code'=>'G302009',
                'service_section_group_description'=>'Paint Protection Film',
                'service_group_id'=>4,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Sublet Services',
                'service_section_group_code'=>'G302010',
                'service_section_group_description'=>'Sublet Services',
                'service_group_id'=>4,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'Quick Lube',
                'service_section_group_code'=>'G303001',
                'service_section_group_description'=>'Quick Lube',
                'service_group_id'=>7,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'ENGINE FLUSH – EFM',
                'service_section_group_code'=>'G303002',
                'service_section_group_description'=>'ENGINE FLUSH – EFM',
                'service_group_id'=>7,
                'created_by'=>1,
                'is_active'=>1,
            ],
            [
                'service_section_group_name'=>'GENERAL OPERATIONS',
                'service_section_group_code'=>'G307001',
                'service_section_group_description'=>'GENERAL OPERATIONS',
                'service_group_id'=>4,
                'created_by'=>1,
                'is_active'=>1,
            ],
        ];

        foreach ($datas as $data) {
            ServicesSectionsGroup::create($data);
        }
    }
}
