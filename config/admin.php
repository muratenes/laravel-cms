<?php

// admin constants
$data = [
    // LOAD CONFIG FROM DATABASE OR FILE
    'config_driver' => env('CONFIG_DRIVER', 'file'),

    'title'           => 'Sütçüler Süt',
    'short_title'     => 'CMS',
    'creator'         => 'sutculersut',
    'creator_link'    => 'http://sutculersut.com',
    'version'         => 'v1.1.0',
    'max_upload_size' => 3024,
    // module status
    'modules_status' => [
        'advert'             => true,
        'banner'             => true,
        'blog'               => true,
        'coupon'             => true,
        'content_management' => true,
        'contact'            => true,
        'campaign'           => true,
        'e_bulten'           => true,
        'gallery'            => true,
        'order'              => true,
        'cargo'              => false,
        'product'            => true,
        'log'                => true,
        'sss'                => true,
        'setting'            => true,
        'reference'          => true,
        'user'               => true,
        'category'           => true,
        'our_team'           => true,
        'role'               => true,
    ],
    'use_album_gallery' => false,

    // multi lang
    'multi_lang'              => true,
    'multi_currency'          => false,
    'default_language'        => 1, // Config::LANG_TR
    'default_currency'        => 1, // Config::CURRENCY_TL
    'default_currency_prefix' => 'tl', // must be : tl,usd,eur
    'force_lang_currency'     => true, // para birimini dile göre varsayılanı seçmeye zorlar

    // DASHBOARD
    'dashboard' => [
        'show_products'      => true,
        'show_orders'        => true,
        'show_order_widgets' => true,
    ],

    // kuponlar kaç dakika geriye kadar  aktif-pasif kontrol edilsin
    'check_coupon_prev_minute'   => 5,
    'check_campaign_prev_minute' => 5,

    // image quality %x if value is null image not be resized
    'image_quality' => [
        'advert'          => 70,
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
    ],
    // admin account
    'username' => 'yilmaz.karabacak@gmail.com',
    'password' => '53257780619901',

    'store_email'    => 'customer@example.com',
    'store_password' => 'customer!1ıDnsnc',

    // SITE CONFIG
    'site' => [
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
    ],
];

$data['menus'] = [
    0 => [
        'title' => 'Modüller',
        'user'  => [
            'icon'       => 'fa fa-user',
            'permission' => 'User@index',
            'title'      => 'users',
            'routeName'  => 'admin.users',
            'status'     => 'modules_status.user',
        ],
        'role' => [
            'icon'       => 'fa fa-user-times',
            'permission' => 'Role@list',
            'title'      => 'role_management',
            'routeName'  => 'admin.roles',
            'status'     => 'modules_status.role',
        ],
        'banner' => [
            'icon'       => 'fa fa-image',
            'permission' => 'Banner@list',
            'title'      => 'banner',
            'routeName'  => 'admin.banners',
            'status'     => 'modules_status.banner',
        ],
        'blog' => [
            'icon'       => 'fa fa-book',
            'permission' => 'Blog@index',
            'title'      => 'blog',
            'routeName'  => 'admin.blog',
            'status'     => 'modules_status.blog',
        ],
        'categories' => [
            'icon'       => 'fa fa-align-center',
            'permission' => 'Category@index',
            'title'      => 'categories',
            'routeName'  => 'admin.categories.index',
            'status'     => 'modules_status.category',
            'subs'       => [
                [
                    'icon'       => 'fa fa-circle-o',
                    'permission' => 'Category@index',
                    'title'      => 'blog_categories',
                    'routeName'  => 'admin.categories.index',
                    'status'     => 'modules.blog.category',
                    'extra'      => '?type=App\Models\Blog',
                ],
                [
                    'icon'       => 'fa fa-circle-o',
                    'permission' => 'Category@index',
                    'title'      => 'content_categories',
                    'routeName'  => 'admin.categories.index',
                    'status'     => 'modules.content.category',
                    'extra'      => '?type=App\Models\Content',
                ],
            ],
        ],
        'our_team' => [
            'icon'       => 'fa fa-users',
            'permission' => 'OurTeam@list',
            'title'      => 'our_team',
            'routeName'  => 'admin.our_team',
            'status'     => 'modules_status.our_team',
        ],
        'contact' => [
            'icon'       => 'fa fa-phone',
            'permission' => 'Contact@list',
            'title'      => 'contact',
            'routeName'  => 'admin.contact',
            'status'     => 'modules_status.contact',
        ],
        'e_bulten' => [
            'icon'       => 'fa fa-envelope',
            'permission' => 'EBulten@list',
            'title'      => 'e_bulten',
            'routeName'  => 'admin.ebulten',
            'status'     => 'modules_status.e_bulten',
        ],

        'product' => [
            'icon'       => 'fa fa-list',
            'permission' => 'Product@listProducts',
            'title'      => 'products',
            'routeName'  => 'admin.products',
            'status'     => 'modules_status.product',
            'subs'       => [
                [
                    'icon'       => 'fa fa-circle-o',
                    'permission' => 'ProductCategory@listProducts',
                    'title'      => 'product_list',
                    'routeName'  => 'admin.products',
                    'status'     => 'modules_status.product',
                ],
            ],
        ],
        'orders' => [
            'icon'       => 'fa fa-shopping-bag',
            'permission' => 'Order@list',
            'title'      => 'orders',
            'routeName'  => 'admin.orders',
            'status'     => 'modules_status.order',
            'subs'       => [
                [
                    'icon'       => 'fa fa-circle-o',
                    'permission' => 'Order@list',
                    'title'      => 'orders',
                    'routeName'  => 'admin.orders',
                    'key'        => 'pendingOrderCount',
                    'status'     => 'modules_status.order',
                ],
                [
                    'icon'       => 'fa fa-undo',
                    'permission' => 'Order@list',
                    'title'      => 'refund_requests',
                    'routeName'  => 'admin.orders',
                    'param'      => '?pendingRefund=1',
                    'key'        => 'pendingRefundRequests',
                    'status'     => 'modules_status.order',
                ],
            ],
        ],
        'references' => [
            'icon'       => 'fa fa-list-alt',
            'permission' => 'Reference@list',
            'title'      => 'references',
            'routeName'  => 'admin.reference',
            'status'     => 'modules_status.reference',
        ],
        'content_management' => [
            'icon'       => 'fa fa-align-center',
            'permission' => 'Content@index',
            'title'      => 'content_management',
            'routeName'  => 'admin.content',
            'status'     => 'modules_status.content_management',
        ],
        'gallery' => [
            'icon'       => 'fa fa-camera',
            'permission' => 'FotoGallery@list',
            'title'      => 'gallery_management',
            'routeName'  => 'admin.gallery',
            'status'     => 'modules_status.gallery',
        ],
        'coupons' => [
            'icon'       => 'fa fa-tags',
            'permission' => 'Coupon@list',
            'title'      => 'coupons',
            'routeName'  => 'admin.coupons',
            'status'     => 'modules_status.coupon',
        ],
        'campaign' => [
            'icon'       => 'fa fa-percent',
            'permission' => 'Campaign@list',
            'title'      => 'campaigns',
            'routeName'  => 'admin.campaigns',
            'status'     => 'modules_status.campaign',
        ],
        'logs' => [
            'icon'       => 'fa fa-exclamation',
            'permission' => 'Log@list',
            'title'      => 'error_management',
            'routeName'  => 'admin.logs',
            'status'     => 'modules_status.log',
        ],
    ], 1 => [
        'title'    => 'Genel',
        'sss' => [
            'icon'       => 'fa fa-info',
            'permission' => 'FAQ@list',
            'title'      => 'faq',
            'routeName'  => 'admin.sss',
            'status'     => 'modules_status.sss',
        ],
    ],
];
$data['modules'] = [
    'product' => [
        'comment'           => true,
        'attribute'         => true, // product detail ex: color - green
        'category'          => true,
        'multiple_category' => false,
        'brand'             => true,
        'company'           => true,
        // features
        'feature'      => true,
        'variant'      => true,
        'gallery'      => true,
        'auto_code'    => false, // generate random auto code
        'qty'          => true,
        'image'        => true,
        'tag'          => true,
        'buying_price' => true,
        'prices'       => true,
        'cargo_price'  => true,
        // attributes
        'max_sub_attribute_count' => 10,
    ],
    'blog' => [
        'tag'      => true,
        'image'    => true,
        'language' => false,
        'category' => true,
        'images'   => true,
    ],
    'order' => [
        'iyzico_logs' => false,
        'cargo'       => true,
    ],
    'content' => [
        'images'   => true,
        'category' => true,
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

return $data;
