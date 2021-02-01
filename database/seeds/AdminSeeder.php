<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Admin::truncate();
        $data = [
            'title' => config('app:.name'),
            'short_title' => 'CMS',
            'creator' => 'muratenes',
            'creator_link' => 'https://github.com/muratenes',
            'max_upload_size' => 3024,
            'multi_lang' => false,
            'multi_currency' => false,
            'default_language' => \App\Models\Ayar::LANG_TR,
            'default_currency' => \App\Models\Ayar::CURRENCY_TL,
            'default_currency_prefix' => 'tl',
            'force_lang_currency' => false,
        ];
        $data['modules'] = [
            'product' => [
                'use_comment' => true,
                'use_attribute' => true, // product detail ex: color - green
                'use_category' => true,
                'multiple_category' => false,
                'use_brand' => true,
                'use_companies' => true,
                'use_gallery' => true,
                // features
                'features' => true,
                'variants' => true,
                'gallery' => true,
                'auto_code' => false, // generate random auto code
                'qty' => true,
                'use_image' => true,
                'use_tags' => true,
                'buying_price' => true,
                'prices' => true,
                'cargo_price' => true,
                // attributes
                'max_sub_attribute_count' => 10
            ],
            'icon' => 'fa fa-user',
            'permission' => 'Kullanici@listUsers',
            'title' => 'users',
            'routeName' => 'admin.users',
        ];
        $data['modules_status'] = [
            'banner' => true,
            'blog' => true,
            'coupon' => true,
            'content_management' => true,
            'contact' => true,
            'campaign' => true,
            'e_bulten' => true,
            'gallery' => true,
            'order' => true,
            'cargo' => true,
            'product' => true,
            'log' => true,
            'sss' => true,
            'setting' => true,
            'reference' => true,
            'user' => true,
            'our_team' => false
        ];
        $data['dashboard'] = [
            'show_products' => true,
            'show_orders' => true,
            'show_order_widgets' => true,
        ];
        $data['image_quality'] = [
            'banner' => 90,
            'blog' => null,
            'our_team' => null,
            'category' => null,
            'product' => null,
            'product_image' => null,
            'product_company' => null,
            'content' => null,
            'reference' => null,
            'coupon' => null,
            'campaign' => null,
            'gallery' => null,
            'gallery_item' => 60,
        ];
//        dd($data);
        $admin = \App\Models\Admin::create($data);
        \App\Models\Admin::setCache($admin);
    }
}
