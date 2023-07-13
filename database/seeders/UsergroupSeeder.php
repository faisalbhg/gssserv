<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Usergroup;

class UsergroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas =   [
            ['user_group' => 'Administrator'],
            ['user_group' => 'Management'],
            ['user_group' => 'Operation'],
            ['user_group' => 'Finance'],
            ['user_group' => 'Customer Service'] ];
        
        foreach ($datas as $data) {
            Usergroup::create($data);
        }
    }
}
