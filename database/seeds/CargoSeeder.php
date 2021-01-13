<?php

use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cargos = [
            [
                'title' => 'Sürat Kargo',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'cargo_tracking_url' => "https://www.suratkargo.com.tr/KargoTakip/?kargotakipno="
            ],
            [
                'title' => 'Aras Kargo',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'cargo_tracking_url' => "http://kargotakip.araskargo.com.tr/mainpage.aspx?code="
            ],
            [
                'title' => 'Mng Kargo',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'cargo_tracking_url' => "http://service.mngkargo.com.tr/iactive/popup/KargoTakip/link1.asp?k="
            ],
            [
                'title' => 'PTT Kargo',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'cargo_tracking_url' => "https://gonderitakip.ptt.gov.tr/Track/Verify?q="
            ],
            [
                'title' => 'Yurtiçi Kargo',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'cargo_tracking_url' => "https://www.yurticikargo.com/tr/online-servisler/gonderi-sorgula?code="
            ],
            [
                'title' => 'UPS Kargo',
                'country_id' => \App\Models\Region\Country::TURKEY,
                'cargo_tracking_url' => "https://www.ups.com/track?loc=tr_TR&tracknum="
            ],

        ];
        foreach ($cargos as $cargo) {
            \App\Models\Cargo::updateOrCreate(['title' => $cargo['title']], $cargo);
        }
    }
}
