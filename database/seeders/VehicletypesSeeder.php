<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Vehicletypes;

class VehicletypesSeeder extends Seeder
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
            ['type_name' => 'Small'],
            ['type_name' => 'CSUV'],
            ['type_name' => 'XSUV'],
            ['type_name' => 'Caravan'],
            ['type_name' => 'Jet Ski'],
            ['type_name' => 'Boat'],
            ['type_name' => 'Bike'],
        ];

        foreach ($datas as $data) {
            Vehicletypes::create($data);
        }
    }
}
