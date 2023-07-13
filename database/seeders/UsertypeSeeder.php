<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Usertype;

class UsertypeSeeder extends Seeder
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
            ['user_type' => 'Admin'],
            ['user_type' => 'Management'],
            ['user_type' => 'Operation'],
            ['user_type' => 'Sales'],
            ['user_type' => 'Accounts'],
            ['user_type' => 'Customer Service'] 
        ];

        foreach ($datas as $data) {
            Usertype::create($data);
        }
    }
}
