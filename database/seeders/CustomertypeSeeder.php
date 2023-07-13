<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Customertype;

class CustomertypeSeeder extends Seeder
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
            ['customer_type' => 'STAFF','description'=>''],
            ['customer_type' => 'FAZZA','description'=>''],
            ['customer_type' => 'Corporate','description'=>''],
        ];

        foreach ($datas as $data) {
            Customertype::create($data);
        }
    }
}
