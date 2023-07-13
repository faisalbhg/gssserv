<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Customers;

class CustomersSeeder extends Seeder
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
                'name'=>'Guest',
                'email'=>'guest@buhaleeba.ae',
                'mobile'=>'0555555555',
                'customer_type'=>1,
                'is_active'=>1
            ],
        ];

        foreach ($datas as $data) {
            Customers::create($data);
        }
    }
}
