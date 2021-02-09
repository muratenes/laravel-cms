<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(KategorilerTableSeeder::class);
        $this->call(AdminSeeder::class);
//        $this->call(UrunlerTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UrunAttributeTableSeeder::class);
        $this->call(AyarlarTableSeeder::class);
//        $this->call(CityTownTableSeeder::class);
//        $this->call(CargoSeeder::class);
//        $this->call(AddressSeeder::class);
    }
}
