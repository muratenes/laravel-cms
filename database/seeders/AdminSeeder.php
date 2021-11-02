<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Admin::truncate();
        $data = [
            'title'                   => config('app.name'),
            'short_title'             => 'CMS',
            'creator'                 => 'muratenes',
            'creator_link'            => 'https://github.com/muratenes',
            'max_upload_size'         => 3024,
            'multi_lang'              => false,
            'multi_currency'          => false,
            'default_language'        => \App\Models\Ayar::LANG_TR,
            'default_currency'        => \App\Models\Ayar::CURRENCY_TL,
            'default_currency_prefix' => 'tl',
            'force_lang_currency'     => false,
        ];
        $data['modules'] = $this->modules();
        $data['site'] = $this->getSiteConfig();
        $data['modules_status'] = $this->moduleStatus();
        $data['dashboard'] = [
            'show_products'      => true,
            'show_orders'        => true,
            'show_order_widgets' => true,
        ];
        $data['image_quality'] = [
            'banner'          => 90,
            'blog'            => null,
            'our_team'        => null,
            'category'        => null,
            'product'         => null,
            'product_image'   => null,
            'product_company' => null,
            'content'         => null,
            'reference'       => null,
            'coupon'          => null,
            'campaign'        => null,
            'gallery'         => null,
            'gallery_item'    => 60,
        ];
//        dd($data);
        $admin = \App\Models\Admin::create($data);
        \App\Models\Admin::setCache($admin);
    }

    private function getSiteConfig()
    {
        return [
            'theme' => [
                'name'    => 'theme_1',
                'banner'  => 'banner_1.blade.php',
                'header'  => 'header_1.blade.php',
                'footer'  => 'footer_1.blade.php',
                'contact' => 'contact_1.blade.php',
            ],
            'menu' => [
                ['title' => 'Anasayfa', 'href' => '/', 'status' => true, 'order' => 1, 'module' => null],
                ['title' => 'Hakkımızda', 'href' => '/hakkimizda', 'status' => true, 'order' => 2, 'module' => null],
            ],
        ];
    }

    private function modules()
    {
        return [
            'product' => [
                'comment'           => true,
                'attribute'         => true, // product detail ex: color - green
                'category'          => true,
                'multiple_category' => false,
                'brand'             => true,
                'company'           => true,
                // features
                'feature'      => false,
                'variant'      => false,
                'gallery'      => true,
                'auto_code'    => false, // generate random auto code
                'qty'          => false,
                'image'        => true,
                'tag'          => false,
                'buying_price' => true,
                'prices'       => false,
                'cargo_price'  => true,
                // attributes
                'max_sub_attribute_count' => 10,
            ],
            'blog' => [
                'tag'      => true,
                'image'    => true,
                'language' => false,
                'category' => false,
            ],
            'order' => [
                'iyzico_logs' => true,
                'cargo'       => true,
            ],
            'contact' => [
                'columns'     => 'name|subject|email|phone|message',
                'fields'      => 'Başlık|Konu|Email|Telefon|Mesaj',
                'validations' => [
                    'email'   => 'required|max:100',
                    'name'    => 'required|max:100',
                    'message' => 'required|max:250',
                    'phone'   => 'required|max:30',
                ],
                'map'  => true,
                'form' => false,
            ],
        ];
    }

    private function menus()
    {
        return [
            ['title' => 'Anasayfa', 'href' => '/', 'status' => true, 'order' => 1, 'module' => null],
            ['title' => 'Hakkımızda', 'href' => '/hakkimizda', 'status' => true, 'order' => 2, 'module' => null],
        ];
    }

    private function moduleStatus()
    {
        return [
            'banner'             => true,
            'blog'               => true,
            'coupon'             => true,
            'content_management' => true,
            'contact'            => true,
            'campaign'           => true,
            'e_bulten'           => true,
            'gallery'            => true,
            'order'              => true,
            'cargo'              => true,
            'product'            => true,
            'log'                => true,
            'sss'                => true,
            'setting'            => true,
            'reference'          => true,
            'user'               => true,
            'role'               => true,
            'our_team'           => true,
        ];
    }
}
