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
            'title' => config('app.name'),
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
                'comment' => true,
                'attribute' => true, // product detail ex: color - green
                'category' => true,
                'multiple_category' => false,
                'brand' => false,
                'company' => true,
                // features
                'feature' => false,
                'variant' => false,
                'gallery' => true,
                'auto_code' => false, // generate random auto code
                'qty' => false,
                'image' => true,
                'tag' => false,
                'buying_price' => true,
                'prices' => false,
                'cargo_price' => true,
                // attributes
                'max_sub_attribute_count' => 10
            ],
            'blog' => [
                'tag' => true,
                'image' => true,
                'language' => false,
                'category' => false
            ],
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
            'role' => true,
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
        $data['menus'] = $this->menus();
//        dd($data);
        $admin = \App\Models\Admin::create($data);
        \App\Models\Admin::setCache($admin);
    }

    private function menus()
    {
        return [
            0 => [
                'title' => 'Modüller',
                'user' => [
                    'icon' => 'fa fa-user',
                    'permission' => 'Kullanici@listUsers',
                    'title' => 'users',
                    'routeName' => 'admin.users',
                    'status' => 'modules_status.user'
                ],
                'role' => [
                    'icon' => 'fa fa-user-times',
                    'permission' => 'Role@list',
                    'title' => 'role_management',
                    'routeName' => 'admin.roles',
                    'status' => 'modules_status.role',
                ],
                'banner' => [
                    'icon' => 'fa fa-image',
                    'permission' => 'Banner@list',
                    'title' => 'banner',
                    'routeName' => 'admin.banners',
                    'status' => 'modules_status.banner',
                ],
                'blog' => [
                    'icon' => 'fa fa-book',
                    'permission' => 'Blog@list',
                    'title' => 'blog',
                    'routeName' => 'admin.blog',
                    'status' => 'modules_status.blog',
                ],
                'blog_category' => [
                    'icon' => 'fa fa-align-center',
                    'permission' => 'BlogCategory@list',
                    'title' => 'blog_category',
                    'routeName' => 'admin.blog_category',
                    'status' => 'modules.blog.category',
                ],
//                'our_team' => [
//                    'icon' => 'fa fa-users',
//                    'permission' => 'OurTeam@list',
//                    'title' => 'our_team',
//                    'routeName' => 'admin.our_team',
//                ],
//                'contact' => [
//                    'icon' => 'fa fa-phone',
//                    'permission' => 'Contact@list',
//                    'title' => 'contact',
//                    'routeName' => 'admin.contact',
//                ],
//                'e_bulten' => [
//                    'icon' => 'fa fa-envelope',
//                    'permission' => 'EBulten@list',
//                    'title' => 'e_bulten',
//                    'routeName' => 'admin.ebulten',
//                ],
//                'category' => [
//                    'icon' => 'fa fa-files-o',
//                    'permission' => 'Kategori@listCategories',
//                    'title' => 'categories',
//                    'routeName' => 'admin.categories',
//                ],
                'product' => [
                    'icon' => 'fa fa-list',
                    'permission' => 'Urun@listProducts',
                    'title' => 'products',
                    'routeName' => 'admin.products',
                    'status' => 'modules_status.product',
                    'subs' => [
                        [
                            'icon' => 'fa fa-circle-o',
                            'permission' => 'Urun@listProducts',
                            'title' => 'product_list',
                            'routeName' => 'admin.products',
                            'status' => 'modules_status.product',
                        ],
                        [
                            'icon' => 'fa fa-circle-o',
                            'permission' => 'UrunOzellik@list',
                            'title' => 'product_features',
                            'routeName' => 'admin.product.attribute.list',
                            'status' => 'modules.product.attribute',
                        ],
                        [
                            'icon' => 'fa fa-circle-o',
                            'permission' => 'UrunYorum@list',
                            'title' => 'product_comments',
                            'routeName' => 'admin.product.comments.list',
                            'status' => 'modules.product.comment',
                        ],
                    ]
                ],
//                'orders' => [
//                    'icon' => 'fa fa-shopping-bag',
//                    'permission' => 'Siparis@list',
//                    'title' => 'orders',
//                    'routeName' => 'admin.orders',
//                    'subs' => [
//                        ['icon' => 'fa fa-circle-o',
//                            'permission' => 'Urun@listProducts',
//                            'title' => 'orders',
//                            'routeName' => 'admin.orders',
//                            'key' => 'pendingOrderCount',
//                        ],
//                        ['icon' => 'fa fa-undo',
//                            'permission' => 'Urun@listProducts',
//                            'title' => 'refund_requests',
//                            'routeName' => 'admin.orders',
//                            'param' => '?pendingRefund=1',
//                            'key' => 'pendingRefundRequests',
//                        ],
//                    ]
//                ],
//                'references' => [
//                    'icon' => 'fa fa-list-alt',
//                    'permission' => 'Referans@list',
//                    'title' => 'references',
//                    'routeName' => 'admin.reference',
//                ],
//                'content_management' => [
//                    'icon' => 'fa fa-align-center',
//                    'permission' => 'IcerikYonetim@list',
//                    'title' => 'content_management',
//                    'routeName' => 'admin.content',
//                ],
//                'gallery' => [
//                    'icon' => 'fa fa-camera',
//                    'permission' => 'FotoGallery@list',
//                    'title' => 'gallery_management',
//                    'routeName' => 'admin.gallery',
//                ],
//                'error_orders' => [
//                    'icon' => 'fa fa-exclamation',
//                    'permission' => 'Siparis@iyzicoErrorOrderList',
//                    'title' => 'failed_orders',
//                    'routeName' => 'admin.orders.iyzico_logs',
//                ],
//                'coupons' => [
//                    'icon' => 'fa fa-tags',
//                    'permission' => 'Kupon@list',
//                    'title' => 'coupons',
//                    'routeName' => 'admin.coupons',
//                ],
//                'campaign' => [
//                    'icon' => 'fa fa-percent',
//                    'permission' => 'Kampanya@list',
//                    'title' => 'campaigns',
//                    'routeName' => 'admin.campaigns',
//                ],
//                'logs' => [
//                    'icon' => 'fa fa-exclamation',
//                    'permission' => 'Log@list',
//                    'title' => 'error_management',
//                    'routeName' => 'admin.logs',
//                ],
//            ], 1 => [
//                'title' => 'Genel',
//                'settings' => [
//                    'icon' => 'fa fa-key',
//                    'permission' => 'Ayarlar@list',
//                    'title' => 'configs',
//                    'routeName' => 'admin.config.list',
//                    'subs' => [
//                        ['icon' => 'fa fa-key',
//                            'permission' => 'Ayarlar@list',
//                            'title' => 'general',
//                            'routeName' => 'admin.config.list',
//                        ],
//                        ['icon' => 'fa fa-truck',
//                            'permission' => 'Cargo@index',
//                            'title' => 'cargo',
//                            'routeName' => 'admin.cargo.index',
//                        ],
//                    ]
//                ],
//                'product_brands' => [
//                    'icon' => 'fa fa-medium',
//                    'permission' => 'UrunMarka@list',
//                    'title' => 'product_brands',
//                    'routeName' => 'admin.product.brands.list',
//                ],
//                'product_companies' => [
//                    'icon' => 'fa fa-building',
//                    'permission' => 'UrunFirma@list',
//                    'title' => 'product_companies',
//                    'routeName' => 'admin.product.company.list',
//                ],
//                'sss' => [
//                    'icon' => 'fa fa-info',
//                    'permission' => 'SSS@list',
//                    'title' => 'faq',
//                    'routeName' => 'admin.sss',
//                ],
            ],

        ];
    }
}
