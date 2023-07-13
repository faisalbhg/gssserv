<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Sections;

class SectionsSeeder extends Seeder
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
                'section_name'=>'General Service',
                'section_description' => 'General Service'
            ],
            [
                'section_name'=>'General Lube', 
                'section_description' => 'General Lube'
            ],
            [
                'section_name'=>'General Wash',
                'section_description' => 'General Wash'
            ],
        ];

        foreach ($datas as $data) {
            Sections::create($data);
        }
    }
}
