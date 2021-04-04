<?php
/**
 *  Admin modules columns and other configurations
 */
return [
    // PRODUCT COMPANY
    'product_company' => [
        'columns' => [
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'title', 'label' => 'Firma Adı'],
            ['key' => 'slug', 'label' => 'Slug'],
            ['key' => 'phone', 'label' => 'Telefon'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'address', 'label' => 'Adres'],
            ['key' => 'address', 'label' => 'Durum'],
            ['key' => null, 'label' => '#'],
        ]
    ],
    // BANNER
    'banner' => [
        'columns' => [
            ['label' => 'ID'],
            ['label' => 'Başlık'],
            ['label' => 'Alt Başlık'],
            ['label' => 'Görsel'],
            ['label' => 'Link'],
            ['label' => 'Dil'],
            ['label' => 'Durum'],
            ['label' => '#'],
        ],
        'detail' => [
            'fields' => [
                ['name' => 'title', 'component' => 'input', 'type' => 'text', 'label' => 'Başlık', 'width' => '3']
            ]
        ]
    ],
    'advert' => [
        'columns' => [
            ['label' => 'ID'],
            ['label' => 'Başlık'],
            ['label' => 'Alt Başlık'],
            ['label' => 'Görsel'],
            ['label' => 'Tür'],
            ['label' => 'Dil'],
            ['label' => 'Durum'],
            ['label' => '#'],
        ],
        'detail' => [
            'fields' => [
                ['name' => 'title', 'component' => 'input', 'type' => 'text', 'label' => 'Başlık', 'width' => '3']
            ]
        ]
    ]
];
