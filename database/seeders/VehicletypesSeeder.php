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
            ['type_name' => 'Micro'],
            ['type_name' => 'Sedan'],
            ['type_name' => 'Hatchback'],
            ['type_name' => 'Station Wagon'],
            ['type_name' => 'Universal'],
            ['type_name' => 'Liftback'],
            ['type_name' => 'Coupe'],
            ['type_name' => 'Cabriolet'],
            ['type_name' => 'Convertible'],
            ['type_name' => 'Roadster'],
            ['type_name' => 'Targe'],
            ['type_name' => 'Limousine'],
            ['type_name' => 'Muscle car'],
            ['type_name' => 'Sport car'],
            ['type_name' => 'Super car'],
            ['type_name' => 'Sport-Utility Vehicle (SUV)'],
            ['type_name' => 'Crossover'],
            ['type_name' => 'Pickup Truck'],
            ['type_name' => 'Van'],
            ['type_name' => 'Minivan'],
            ['type_name' => 'Minibus'],
            ['type_name' => 'Bus'],
            ['type_name' => 'Campervan'],
        ];

        foreach ($datas as $data) {
            Vehicletypes::create($data);
        }
    }
}
