<?php

namespace Database\Seeders;

use App\Models\Region\Country;
use App\Models\Region\District;
use App\Models\Region\Neighborhood;
use App\Models\Region\State;
use App\Models\UserAddress;
use App\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::first();

        $address = $user->addresses()->create([
            'country_id' => Country::where('title', 'Turkey')->first()->id,

            'state_id'        => State::where('title', 'Istanbul')->first()->id,
            'district_id'     => District::where('title', 'Ataşehir')->first()->id,
            'neighborhood_id' => Neighborhood::where('title', 'BARBAROS MAH.')->first()->id,
            'title'           => 'My Home',
            'name'            => 'John',
            'surname'         => 'Doe',
            'phone'           => '512307124',
            'type'            => UserAddress::TYPE_DELIVERY,
            'adres'           => 'Can sk. Kuzey Apt. No:32 D:6',
        ]);

        $invoiceAddresses = $user->addresses()->create([
            'country_id'      => Country::where('title', 'Turkey')->first()->id,
            'state_id'        => State::where('title', 'Istanbul')->first()->id,
            'district_id'     => District::where('title', 'Ataşehir')->first()->id,
            'neighborhood_id' => Neighborhood::where('title', 'MUSTAFA KEMAL MAH.')->first()->id,
            'title'           => 'Job',
            'name'            => 'Kols',
            'surname'         => 'Okra',
            'phone'           => '512309237',
            'type'            => UserAddress::TYPE_INVOICE,
            'adres'           => 'Ordu Sk. Veysel Apt No :20 D:4',
        ]);

        $user->update([
            'default_invoice_address_id' => $invoiceAddresses->id,
            'default_address_id'         => $address->id,
        ]);
    }
}
