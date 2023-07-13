<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Stationcode;

class StationcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas =   [
            ['station_code' => 'GSS','station_name'=>'Grand Service Station'],
            ['station_code' => 'GAJ','station_name'=>'GSS AJMAN'],
            ['station_code' => 'GBD','station_name'=>'GSS BURDUBAI'],
            ['station_code' => 'GQS','station_name'=>'GSS QUSAIS'],
            ['station_code' => 'GWQ','station_name'=>'GSS WARQA'],
            ['station_code' => 'GWW','station_name'=>'GSS BARSHA'],
        ];
        
        foreach ($datas as $data) {
            Stationcode::create($data);
        }
    }
}
