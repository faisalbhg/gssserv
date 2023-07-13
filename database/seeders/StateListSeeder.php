<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\StateList;

class StateListSeeder extends Seeder
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
            ['state_code'=>'AZ','state_name'=>'Abu Dhabi','is_active'=>1],
            ['state_code'=>'AJ','state_name'=>'Ajman','is_active'=>1],
            ['state_code'=>'DU','state_name'=>'Dubai','is_active'=>1],
            ['state_code'=>'FU','state_name'=>'Fujairah','is_active'=>1],
            ['state_code'=>'RK','state_name'=>'Ras al-Khaimah','is_active'=>1],
            ['state_code'=>'SH','state_name'=>'Sharjah','is_active'=>1],
            ['state_code'=>'UQ','state_name'=>'Umm al-Quwain','is_active'=>1],
        ];

        foreach ($datas as $data) {
            StateList::create($data);
        }
    }
}
