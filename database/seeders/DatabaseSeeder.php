<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UserSeeder::class);

//        $this->call(CityTownTableSeeder::class);
//        $this->call(CargoSeeder::class);
//        $this->call(AddressSeeder::class);
    }
}
