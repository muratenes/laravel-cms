<?php

namespace Database\Seeders;

use App\Models\Vendor;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        // vendors
        $sezerVendor = Vendor::create([
            'title' => "Sezer Kontaş",
            'phone' => "5388932117"
        ]);

        $oktayVendor = Vendor::create([
            'title' => "Oktay Kozak",
            'phone' => "5388932117"
        ]);


        User::create([
            'name' => 'Yılmaz',
            'surname' => 'Karabacak',
            'phone' => '5325778061',
            'email' => 'yilmaz.karabacak@gmail.com',
            'password' => Hash::make("53257780619901"),
            'is_active' => 1,
            'role_id' => \App\Models\Auth\Role::ROLE_SUPER_ADMIN,
        ]);

        User::create([
            'name' => 'Murat',
            'surname' => 'Karabacak',
            'phone' => '5310129339',
            'email' => 'murat.karabacak@gmail.com',
            'password' => Hash::make("53101293399901"),
            'is_active' => 1,
            'role_id' => \App\Models\Auth\Role::ROLE_SUPER_ADMIN,
        ]);

        $sezer = User::create([
            'name' => 'Sezer',
            'surname' => 'Kontaş',
            'vendor_id' => $sezerVendor->id,
            'phone' => $sezerVendor->phone,
            'email' => "sezer.kontas@gmail.com",
            'password' => Hash::make("5388932117"),
            'is_active' => 1,
            'role_id' => \App\Models\Auth\Role::ROLE_VENDOR,
        ]);

        $oktay = User::create([
            'name' => 'Oktay',
            'surname' => 'Kozak',
            'phone' => $oktayVendor->phone,
            'vendor_id' => $oktayVendor->id,
            'email' => 'oktay.kozak@gmail.com',
            'password' => Hash::make("5388583284"),
            'is_active' => 1,
            'role_id' => \App\Models\Auth\Role::ROLE_VENDOR,
        ]);

        User::create([
            'name' => 'Muhasebe',
            'surname' => '',
            'email' => 'muhasebe@gmail.com',
            'password' => Hash::make("123456"),
            'is_active' => 1,
            'role_id' => \App\Models\Auth\Role::ROLE_MANAGER,
        ]);
    }
}
