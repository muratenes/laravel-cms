<?php

namespace Database\Seeders;

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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create([
            'name'      => 'Murat',
            'surname'   => 'Karabacak',
            'email'     => config('admin.username'),
            'password'  => Hash::make(config('admin.password')),
            'is_active' => 1,
            'role_id'   => \App\Models\Auth\Role::where('name', 'super-admin')->first()->id,
        ]);

        User::create([
            'name'      => 'Ali',
            'surname'   => 'Customer',
            'email'     => 'customer@admin.com',
            'password'  => Hash::make(config('admin.store_password')),
            'is_active' => 1,
            'role_id'   => \App\Models\Auth\Role::ROLE_CUSTOMER,
        ]);
        User::create([
            'name'      => 'John',
            'surname'   => 'Manager',
            'email'     => 'manager@admin.com',
            'password'  => Hash::make(config('admin.store_password')),
            'is_active' => 1,
            'role_id'   => \App\Models\Auth\Role::ROLE_MANAGER,
        ]);
        User::factory()->count(10)->create();
    }
}
