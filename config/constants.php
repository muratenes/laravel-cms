<?php
$project_images_path = 'uploads';
$project_images_upload_path = '/public/uploads';
return [
    'image_paths' => [
        'product_image_folder_path' => '/' . $project_images_path . '/products/',
        'product_image_upload_path' => $project_images_upload_path . '/products/',
        'product270x250_folder_path' => '/' . $project_images_path . '/products270x250/',
        'product270x250_upload_path' => $project_images_upload_path . '/products270x250/',
        'product_gallery_upload_path' => $project_images_upload_path . '/productsGallery/',
        'product_gallery_folder_path' => '/' . $project_images_path . '/productsGallery/',
        'banner_image_upload_path' => $project_images_upload_path . '/banners/',
        'banner_image_folder_path' => '/' . $project_images_path . '/banners/',
        'config_image_folder_path' => $project_images_path . '/ayarlar/',
        'campaign_image_folder_path' => $project_images_path . '/kampanyalar/',
        'brand_image_folder_path' => $project_images_path . '/markalar/',
        'company_image_folder_path' => $project_images_path . '/firmalar/',
        'content_image_upload_path' => $project_images_path . '/icerikyonetim/',
        'content_image_folder_path' => '/' . $project_images_path . '/icerikyonetim/',
        'reference_image_folder_path' => '/' . $project_images_path . '/referanslar/',
        'reference_image_upload_path' => $project_images_path . '/referanslar/',
        'our_team_image_upload_path' => $project_images_upload_path . '/our_team/',
        'our_team_image_folder_path' => '/' . $project_images_path . '/our_team/',
        'blog_image_upload_path' => $project_images_path . '/blog/',
        'blog_image_folder_path' => '/' . $project_images_path . '/blog/',
        'gallery_main_image_folder_path' => '/' . $project_images_path . '/galeri/',
        'gallery_main_image_upload_path' => $project_images_path . '/galeri/',
    ],
    'messages' => [
        'success_message' => 'İşlem başarılı şekilde gerçekleşti',
        'error_message' => 'İşlem gerçekleştirilirken bir hata oluştu'
    ],
    'cargo_price' => 10,
    'default_per_page_item' => 20,
];

