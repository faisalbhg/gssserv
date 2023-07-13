<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Useraccess;

class UseraccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Useraccess::create([
            'user_id' => 1,
            'user_group' => 1,
            'privilege_id'=>1,
            'station_id'=>1
        ]);
    }
}
