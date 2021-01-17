<?php

// admin constants
$data = [
    'title' => 'CMS Yönetim',
    'short_title' => 'CMS',
    'creator' => 'NeAjans',
    'creator_link' => 'http://google.com',
    'version' => 'v1.0.2',
    'max_upload_size' => 3024,
    // module status
    'module_status' => [
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
    ],
    'blog' => [
        'use_tags' => true,
        'use_image' => true,
        'use_language' => false,
        'use_categories' => false
    ],
    'product' => [
        // sub modules
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
    'use_album_gallery' => false,

    // multi lang
    'MULTI_LANG' => true,
    'multi_currency' => true,
    'default_language' => 1, // Ayar::LANG_TR
    'default_currency' => 1, // Ayar::CURRENCY_TL
    'default_currency_prefix' => 'tl', // must be : tl,usd,eur
    'force_lang_currency' => true, // para birimini dile göre varsayılanı seçmeye zorlar

    // index page configs
    'homepage' => [
        'show_products' => true,
        'show_orders' => true,
        'show_order_widgets' => true,
    ],

    // kuponlar kaç dakika geriye kadar  aktif-pasif kontrol edilsin
    'check_coupon_prev_minute' => 5,
    'check_campaign_prev_minute' => 5,

    'iyzico' => [
        'order_url' => env("IYZIPAY_ORDER_URL", "https://sandbox-merchant.iyzipay.com/transactions/"),
        'api_key' => env('IYZIPAY_API_KEY', "DEFAULT_KEY"),
        'api_secret' => env('IYZIPAY_API_SECRET', "DEFAULT_SECRET_KEY"),
        'base_url' => env('IYZIPAY_BASE_URL', "DEFAULT_BASE_URL"),
    ],
    // image quality %x if value is null image not be resized
    'image_quality' => [
        'banner' => 90,
        'blog' => null,
        'our_team' => null,
        'category' => null,
        'product' => null,
        'product_image' => null,
        'content' => null,
        'reference' => null,
        'coupon' => null,
        'campaign' => null,
        'gallery' => null,
        'gallery_item' => 60
    ],
    // admin account
    'username' => 'admin@admin.com',
    'password' => 'adminadmin',

    'store_email' => 'customer@example.com',
    'store_password' => 'customer!1ıDnsnc',

];
$data['menus'] = [
    0 => [
        'title' => 'Modüller',
        'users' => [
            'icon' => 'fa fa-user',
            'permission' => 'Kullanici@listUsers',
            'title' => 'Kullanicilar',
            'routeName' => 'admin.users',
            'active' => $data['module_status']['user']
        ],
        'roles' => [
            'icon' => 'fa fa-user-times',
            'permission' => 'Role@list',
            'title' => 'Rol Yönetimi',
            'routeName' => 'admin.roles',
            'active' => $data['module_status']['user']
        ],
        'banner' => [
            'icon' => 'fa fa-image',
            'permission' => 'Banner@list',
            'title' => 'Banner',
            'routeName' => 'admin.banners',
            'active' => $data['module_status']['banner']
        ],
        'blog' => [
            'icon' => 'fa fa-book',
            'permission' => 'Blog@list',
            'title' => 'Blog',
            'routeName' => 'admin.blog',
            'active' => $data['module_status']['blog']
        ],
        'blog_category' => [
            'icon' => 'fa fa-align-center',
            'permission' => 'BlogCategory@list',
            'title' => 'Blog Kategori',
            'routeName' => 'admin.blog_category',
            'active' => $data['blog']['use_categories']
        ],
        'our_team' => [
            'icon' => 'fa fa-users',
            'permission' => 'OurTeam@list',
            'title' => 'Takımımız',
            'routeName' => 'admin.our_team',
            'active' => $data['module_status']['our_team']
        ],
        'contact' => [
            'icon' => 'fa fa-phone',
            'permission' => 'Contact@list',
            'title' => 'İletişim',
            'routeName' => 'admin.contact',
            'active' => $data['module_status']['contact']
        ],
        'e_bulten' => [
            'icon' => 'fa fa-envelope',
            'permission' => 'EBulten@list',
            'title' => 'E-Bülten',
            'routeName' => 'admin.ebulten',
            'active' => $data['module_status']['e_bulten']
        ],
        'category' => [
            'icon' => 'fa fa-files-o',
            'permission' => 'Kategori@listCategories',
            'title' => 'Kategoriler',
            'routeName' => 'admin.categories',
            'active' => $data['product']['use_category']
        ],
        'products' => [
            'icon' => 'fa fa-list',
            'permission' => 'Urun@listProducts',
            'title' => 'Ürünler',
            'routeName' => 'admin.products',
            'active' => $data['module_status']['product'],
            'subs' => [
                ['icon' => 'fa fa-circle-o',
                    'permission' => 'Urun@listProducts',
                    'title' => 'Ürün Listesi',
                    'routeName' => 'admin.products',
                    'active' => $data['module_status']['product']
                ],
                ['icon' => 'fa fa-circle-o',
                    'permission' => 'UrunOzellik@list',
                    'title' => 'Ürün Özellikleri',
                    'routeName' => 'admin.product.attribute.list',
                    'active' => $data['product']['use_attribute']
                ],
                ['icon' => 'fa fa-circle-o',
                    'permission' => 'UrunYorum@list',
                    'title' => 'Ürün Yorumları',
                    'routeName' => 'admin.product.comments.list',
                    'active' => $data['product']['use_comment']
                ],
            ]
        ],
        'orders' => [
            'icon' => 'fa fa-shopping-bag',
            'permission' => 'Siparis@list',
            'title' => 'Siparişler',
            'routeName' => 'admin.orders',
            'active' => $data['module_status']['order'],
            'subs' => [
                ['icon' => 'fa fa-circle-o',
                    'permission' => 'Urun@listProducts',
                    'title' => 'Siparişler',
                    'routeName' => 'admin.orders',
                    'key' => 'pendingOrderCount',
                    'active' => $data['module_status']['order']
                ],
                ['icon' => 'fa fa-undo',
                    'permission' => 'Urun@listProducts',
                    'title' => 'İade Talepleri',
                    'routeName' => 'admin.orders',
                    'param' => '?pendingRefund=1',
                    'key' => 'pendingRefundRequests',
                    'active' => $data['module_status']['order']
                ],
            ]
        ],
        'references' => [
            'icon' => 'fa fa-list-alt',
            'permission' => 'Referans@list',
            'title' => 'Referanslar',
            'routeName' => 'admin.reference',
            'active' => $data['module_status']['reference']
        ],
        'content_management' => [
            'icon' => 'fa fa-align-center',
            'permission' => 'IcerikYonetim@list',
            'title' => 'İçerik Yönetim',
            'routeName' => 'admin.content',
            'active' => $data['module_status']['content_management']
        ],
        'gallery' => [
            'icon' => 'fa fa-camera',
            'permission' => 'FotoGallery@list',
            'title' => 'Galeri Yönetim',
            'routeName' => 'admin.gallery',
            'active' => $data['module_status']['gallery']
        ],
        'error_orders' => [
            'icon' => 'fa fa-exclamation',
            'permission' => 'Siparis@iyzicoErrorOrderList',
            'title' => 'Hatalı Siparişler',
            'routeName' => 'admin.orders.iyzico_logs',
            'active' => $data['module_status']['order']
        ],
        'coupons' => [
            'icon' => 'fa fa-tags',
            'permission' => 'Kupon@list',
            'title' => 'Kuponlar',
            'routeName' => 'admin.coupons',
            'active' => $data['module_status']['coupon']
        ],
        'campaign' => [
            'icon' => 'fa fa-percent',
            'permission' => 'Kampanya@list',
            'title' => 'Kampanyalar',
            'routeName' => 'admin.campaigns',
            'active' => $data['module_status']['campaign']
        ],
        'logs' => [
            'icon' => 'fa fa-exclamation',
            'permission' => 'Log@list',
            'title' => 'Hata Yönetimi',
            'routeName' => 'admin.logs',
            'active' => $data['module_status']['log']
        ],
    ], 1 => [
        'title' => 'Genel',
        'settings' => [
            'icon' => 'fa fa-key',
            'permission' => 'Ayarlar@list',
            'title' => 'Ayarlar',
            'routeName' => 'admin.config.list',
            'active' => $data['module_status']['setting'],
            'subs' => [
                ['icon' => 'fa fa-key',
                    'permission' => 'Ayarlar@list',
                    'title' => 'Genel',
                    'routeName' => 'admin.config.list',
                    'active' => $data['module_status']['setting']
                ],
                ['icon' => 'fa fa-truck',
                    'permission' => 'Cargo@index',
                    'title' => 'Kargo',
                    'routeName' => 'admin.cargo.index',
                    'active' => $data['module_status']['cargo']
                ],
            ]
        ],
        'product_brands' => [
            'icon' => 'fa fa-medium',
            'permission' => 'UrunMarka@list',
            'title' => 'Ürün Markaları',
            'routeName' => 'admin.product.brands.list',
            'active' => $data['product']['use_brand']
        ],
        'product_companies' => [
            'icon' => 'fa fa-building',
            'permission' => 'UrunFirma@list',
            'title' => 'Ürün Firmaları',
            'routeName' => 'admin.product.company.list',
            'active' => $data['product']['use_companies']
        ],
        'sss' => [
            'icon' => 'fa fa-info',
            'permission' => 'SSS@list',
            'title' => 'Sık Sorulan Sorular',
            'routeName' => 'admin.sss',
            'active' => $data['module_status']['sss']
        ],
    ],

];
return $data;
