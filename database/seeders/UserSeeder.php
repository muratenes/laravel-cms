<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorProduct;
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


        // products

        $sut = Product::create([
            'name' => 'Süt',
            'purchase_price' => 30,
            'price' => 35,
            'stock_follow' => false,
        ]);

        Product::create([
            'name' => 'Simental Süt',
            'purchase_price' => 50,
            'price' => 60,
            'stock_follow' => false,
        ]);

        Product::create([
            'name' => 'Pet',
            'purchase_price' => 4,
            'price' => 8,
            'stock_follow' => true,
        ]);

        Product::create([
            'name' => 'Tereyağ',
            'purchase_price' => 300,
            'price' => 350,
            'stock_follow' => true,
        ]);

        Product::create([
            'name' => 'Yumurta 30lu',
            'purchase_price' => 100,
            'price' => 140,
            'stock_follow' => true,
        ]);

        VendorProduct::create([
            'vendor_id' => $sezerVendor->id,
            'product_id' => $sut->id,
            'price' => 32,
        ]);

        VendorProduct::create([
            'vendor_id' => $oktayVendor->id,
            'product_id' => $sut->id,
            'price' => 32,
        ]);
    }
}
