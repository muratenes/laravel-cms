<?php

namespace Database\Seeders;


use App\Models\Region\Country;
use Illuminate\Database\Seeder;

class CityTownTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->insertCountries();

        $turkey = Country::where('title', 'Turkey')->first();
        $germany = Country::where('title', 'Germany')->first();

        // turkey city inserts
        $this->insertTurkeyCities($turkey);
//        $this->insertGermanyCountries($germany);
    }

    private function insertCountries()
    {
        $countryJson = json_decode(file_get_contents(database_path('seeds/files/countries.json'), true));
        foreach ($countryJson as $country) {
            $country = (array) $country;
            Country::firstOrCreate([
                'title' => $country['Name'],
                'code'  => $country['Code'],
            ]);
        }
    }

    private function insertTurkeyCities(Country $turkey)
    {
        $turkeyCities = json_decode(file_get_contents(database_path('seeds/files/turkey.json')), true);
        foreach ($turkeyCities as $index => $state) {
            // $index = il     ex:istanbul
            // $index2 = ilçe  ex:adalar
            // $towns = semtler  ex:büyük ada
            // $neighborhood = mahalle  ex: MADEN MAH.
            $stateModel = $turkey->states()->firstOrCreate(['title' => $index]);
            foreach ($state as $index2 => $towns) {
                $districtModel = $stateModel->districts()->firstOrCreate(['title' => $index2]);
                foreach ($towns as $index3 => $neighborhoods) {
                    foreach ($neighborhoods as $neighborhood) {
                        $districtModel->neighborhoods()->firstOrCreate(['title' => $neighborhood]);
                    }
                }
            }
        }
    }

    /**
     * @param Country $germany
     */
    private function insertGermanyCountries(Country $germany)
    {
        $germanyCountries = json_decode(file_get_contents(database_path('seeds/files/germany_cities.json')), true);
        foreach ($germanyCountries as $item) {
            $stateModel = $germany->states()->firstOrCreate(['title' => $item['state']]);
            if (isset($item['district'])) {
                $districtModel = $stateModel->districts()->firstOrCreate(['title' => $item['district']]);
                $districtModel->neighborhoods()->firstOrCreate(['title' => $item['name']]);
            } else {
                $stateModel->districts()->firstOrCreate(['title' => $item['name']]);
            }
        }
    }
}
