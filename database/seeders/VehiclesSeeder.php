<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Vehicles;

class VehiclesSeeder extends Seeder
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
            ['vehicle_name' => 'AM General'],
            ['vehicle_name' => 'Acura'],
            ['vehicle_name' => 'Alfa Romeo'],
            ['vehicle_name' => 'Audi'],
            ['vehicle_name' => 'BAIC'],
            ['vehicle_name' => 'BAW'],
            ['vehicle_name' => 'BMW'],
            ['vehicle_name' => 'BYD'],
            ['vehicle_name' => 'Bentley'],
            ['vehicle_name' => 'Brilliance'],
            ['vehicle_name' => 'Buick'],
            ['vehicle_name' => 'Cadillac'],
            ['vehicle_name' => 'Chana'],
            ['vehicle_name' => 'Chery'],
            ['vehicle_name' => 'Chevrolet'],
            ['vehicle_name' => 'Chrysler'],
            ['vehicle_name' => 'Coda'],
            ['vehicle_name' => 'Dacia'],
            ['vehicle_name' => 'Daewoo'],
            ['vehicle_name' => 'Datsun'],
            ['vehicle_name' => 'Dodge'],
            ['vehicle_name' => 'Fiat'],
            ['vehicle_name' => 'Force'],
            ['vehicle_name' => 'Ford'],
            ['vehicle_name' => 'GAC Toyota'],
            ['vehicle_name' => 'GM'],
            ['vehicle_name' => 'GMC'],
            ['vehicle_name' => 'Genesis'],
            ['vehicle_name' => 'Hafei'],
            ['vehicle_name' => 'Honda'],
            ['vehicle_name' => 'Hongqi'],
            ['vehicle_name' => 'Hummer'],
            ['vehicle_name' => 'Hyundai'],
            ['vehicle_name' => 'IKCO'],
            ['vehicle_name' => 'Infiniti'],
            ['vehicle_name' => 'Isuzu'],
            ['vehicle_name' => 'Jaguar'],
            ['vehicle_name' => 'Jeep'],
            ['vehicle_name' => 'Kia'],
            ['vehicle_name' => 'LCK'],
            ['vehicle_name' => 'LDV'],
            ['vehicle_name' => 'Lada'],
            ['vehicle_name' => 'Land Rover'],
            ['vehicle_name' => 'Landwind'],
            ['vehicle_name' => 'Lexus'],
            ['vehicle_name' => 'Lifan'],
            ['vehicle_name' => 'Lincoln'],
            ['vehicle_name' => 'Maruti Suzuki'],
            ['vehicle_name' => 'Maserati'],
            ['vehicle_name' => 'Maybach'],
            ['vehicle_name' => 'Mazda'],
            ['vehicle_name' => 'Mercedes-Benz'],
            ['vehicle_name' => 'Mercury'],
            ['vehicle_name' => 'Mini'],
            ['vehicle_name' => 'Mitsubishi'],
            ['vehicle_name' => 'Naza'],
            ['vehicle_name' => 'Nissan'],
            ['vehicle_name' => 'Oldsmobile'],
            ['vehicle_name' => 'Polestar'],
            ['vehicle_name' => 'Pontiac'],
            ['vehicle_name' => 'Porsche'],
            ['vehicle_name' => 'Qoros'],
            ['vehicle_name' => 'RAM'],
            ['vehicle_name' => 'Ram Trucks'],
            ['vehicle_name' => 'Rivian'],
            ['vehicle_name' => 'Rolls-Royce'],
            ['vehicle_name' => 'Rover'],
            ['vehicle_name' => 'Saab'],
            ['vehicle_name' => 'Saipa'],
            ['vehicle_name' => 'Saturn'],
            ['vehicle_name' => 'Scion'],
            ['vehicle_name' => 'Subaru'],
            ['vehicle_name' => 'Suzuki'],
            ['vehicle_name' => 'Tesla'],
            ['vehicle_name' => 'Toyota'],
            ['vehicle_name' => 'Volkswagen'],
            ['vehicle_name' => 'Volvo'],
            ['vehicle_name' => 'Vortex'],
            ['vehicle_name' => 'ZAZ'],
            ['vehicle_name' => 'ZXAUTO'],
        ];

        foreach ($datas as $data) {
            Vehicles::create($data);
        }
    }
}
