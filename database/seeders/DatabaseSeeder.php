<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StationcodeSeeder::class);
        $this->call(UsergroupSeeder::class);
        $this->call(UsertypeSeeder::class);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'it@gss.ae',
            'password' => Hash::make('Gss123'),
            'station_id'=>4,
            'station_code'=>'GQS',
            'user_type'=>13,
            //'created_by'=>1,
            'updated_by'=>0,
            'is_active'=>1,
            'is_blocked'=>0,
        ]);

        $this->call(UseraccessSeeder::class);
        

        $this->call(CustomertypeSeeder::class);
        $this->call(VehicletypesSeeder::class);
        $this->call(VehiclesSeeder::class);
        
        
    }
}
