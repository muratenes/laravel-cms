<?php

/*
|--------------------------------------------------------------------------
| Web Admin Routes
|--------------------------------------------------------------------------
|
 */

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Services\DashboardService;

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::redirect('', '/admin/giris/');
//    Route::match(['get', 'post'], 'giris', 'AuthController@login')->name('admin.login');
    Route::get('giris', 'AuthController@loginView')->name('admin.login');
    Route::post('giris', 'AuthController@login')->name('admin.login.post');
    Route::get('/clear_cache', 'HomeController@cacheClear')->name('admin.clearCache');
    Route::get('/init', [DashboardController::class,'init']);
    Route::view('/add-new-order', 'admin.order.partials.add-new-order',(new DashboardService())->init());

    Route::group(['middleware' => ['admin', 'admin.module', 'role', 'admin.counts', 'admin.data']], function () {
        Route::get('storage-link', function () {
            return Artisan::call('storage:link');
        });
        Route::get('home', 'HomeController@index')->name('admin.home_page');
        Route::get('contacts', 'HomeController@contacts')->name('admin.contacts');
        Route::get('cikis', 'AuthController@logout')->name('admin.logout');

        //----- Admin/User/..
        Route::group(['prefix' => 'user/'], function () {
            Route::get('/', 'UserController@index')->name('admin.users');
            Route::get('create', 'UserController@create')->name('admin.user.create');
            Route::get('edit/{user:id}', 'UserController@edit')->name('admin.user.edit');
            Route::post('', 'UserController@store')->name('admin.user.store');
            Route::put('{user:id}', 'UserController@update')->name('admin.user.update');
            Route::delete('{user:id}', 'UserController@delete')->name('admin.user.delete');
        });

        //----- Admin/Category/..
        Route::group(['prefix' => 'category/'], function () {
            Route::get('/', 'CategoryController@index')->name('admin.categories.index');
            Route::get('{category:id}/sub-categories', 'CategoryController@subCategories')->name('admin.categories.sub-categories');
            Route::get('type', 'CategoryController@categoriesByType')->name('admin.categories.categories-by-type');
            Route::get('create', 'CategoryController@create')->name('admin.categories.create');
            Route::get('{category:id}', 'CategoryController@show')->name('admin.categories.edit');
            Route::post('', 'CategoryController@store')->name('admin.categories.store');
            Route::put('{category:id}', 'CategoryController@update')->name('admin.categories.update');
            Route::delete('{category:id}', 'CategoryController@delete')->name('admin.categories.delete');
        });


        //----- Admin/Products/..
        Route::group(['prefix' => 'product/'], function () {
            Route::get('/', [ProductController::class, 'listProducts'])->name('admin.products');
            Route::get('new', [ProductController::class, 'newProduct'])->name('admin.product.new');
            Route::get('edit/{product:id}', [ProductController::class, 'editProduct'])->name('admin.product.edit');
            Route::post('save/{product_id}', 'ProductController@saveProduct')->name('admin.product.save');
            Route::get('delete/{product:id}', 'ProductController@deleteProduct')->name('admin.product.delete');

            Route::post('{product:id}/save-custom-prices', [ProductController::class, 'saveCustomPrices'])->name('admin.product.save-custom-prices');

            // ajax
            Route::get('ajax', 'ProductController@ajax');
            Route::get('getAllProductsForSearch', 'ProductController@getAllProductsForSearchAjax');
            Route::get('deleteProductDetailById/{id}', 'ProductController@deleteProductDetailById')->name('deleteProductDetailById');
            Route::get('getProductDetailWithSubAttributes/{product_id}', 'ProductController@getProductDetailWithSubAttributes')->name('getProductDetailWithSubAttributes');
            Route::get('deleteProductVariant/{variant_id}', 'ProductController@deleteProductVariant')->name('deleteProductVariant');
            Route::get('deleteProductImage/{id}', 'ProductController@deleteProductImage')->name('deleteProductImage');
            Route::post('clone-for-language/{product:id}/{lang}', 'ProductController@cloneForLanguage')->name('admin.product.clone-for-language');
        });

        //----- Admin/Orders/..
        Route::group(['prefix' => 'order/'], function () {
            Route::get('/', [OrderController::class, 'list'])->name('admin.orders');
            Route::get('edit/{orderId}', 'OrderController@newOrEditOrder')->name('admin.order.edit');
            Route::post('save/{orderId}', 'OrderController@save')->name('admin.order.save');
            Route::get('delete/{id}', 'OrderController@deleteOrder')->name('admin.order.delete');

            Route::get('ajax', 'OrderController@ajax')->name('admin.order.ajax');

            Route::post('create',[OrderController::class,'createOrder'])->name('admin.order.create');
        });

        //----- Admin/Banners/..
        Route::group(['prefix' => 'banner/'], function () {
            Route::get('/', 'BannerController@list')->name('admin.banners');
            Route::get('new', 'BannerController@edit')->name('admin.banners.new');
            Route::get('edit/{banner:id}', 'BannerController@edit')->name('admin.banners.edit');
            Route::post('save/{id}', 'BannerController@save')->name('admin.banners.save');
            Route::delete('{banner:id}', 'BannerController@delete')->name('admin.banners.delete');
        });

        //----- Admin/Logs/..
        Route::group(['prefix' => 'logs/'], function () {
            Route::get('/', 'LogController@list')->name('admin.logs');
            Route::get('show/{id}', 'LogController@show')->name('admin.log.show');
            Route::get('json/{log:id}', 'LogController@json')->name('admin.log.json');
            Route::get('delete/{id}', 'LogController@delete')->name('admin.log.delete');
            Route::get('deleteAll', 'LogController@deleteAll')->name('admin.log.delete_all');
        });

        //----- Admin/Coupons/..
        Route::group(['prefix' => 'coupon/'], function () {
            Route::get('/', 'CouponController@list')->name('admin.coupons');
            Route::get('new', 'CouponController@newOrEditForm')->name('admin.coupons.new');
            Route::get('edit/{id}', 'CouponController@newOrEditForm')->name('admin.coupons.edit');
            Route::post('save/{id}', 'CouponController@save')->name('admin.coupons.save');
            Route::get('delete/{id}', 'CouponController@delete')->name('admin.coupons.delete');
        });

        //----- Admin/Campaigns/..
        Route::group(['prefix' => 'campaigns/'], function () {
            Route::get('/', 'CampaignController@list')->name('admin.campaigns');
            Route::get('new', 'CampaignController@newOrEditForm')->name('admin.campaigns.new');
            Route::get('edit/{id}', 'CampaignController@newOrEditForm')->name('admin.campaigns.edit');
            Route::post('save/{id}', 'CampaignController@save')->name('admin.campaigns.save');
            Route::get('delete/{id}', 'CampaignController@delete')->name('admin.campaigns.delete');
        });

        //----- Admin/Coupons/..
        Route::group(['prefix' => 'sss/'], function () {
            Route::get('/', 'SSSController@list')->name('admin.sss');
            Route::get('new', 'SSSController@newOrEditForm')->name('admin.sss.new');
            Route::get('edit/{id}', 'SSSController@newOrEditForm')->name('admin.sss.edit');
            Route::post('save/{id}', 'SSSController@save')->name('admin.sss.save');
            Route::get('delete/{id}', 'SSSController@delete')->name('admin.sss.delete');
        });

        //----- Admin/References/..
        Route::group(['prefix' => 'references/'], function () {
            Route::get('/', 'ReferenceController@list')->name('admin.reference');
            Route::get('new', 'ReferenceController@newOrEditForm')->name('admin.reference.new');
            Route::get('edit/{id}', 'ReferenceController@newOrEditForm')->name('admin.reference.edit');
            Route::post('save/{id}', 'ReferenceController@save')->name('admin.reference.save');
            Route::get('delete/{id}', 'ReferenceController@delete')->name('admin.reference.delete');
        });
        //----- Admin/PhotoGallery/..
        Route::group(['prefix' => 'photo-gallery/'], function () {
            Route::get('/', 'FotoGalleryController@list')->name('admin.gallery');
            Route::get('new', 'FotoGalleryController@newOrEditForm')->name('admin.gallery.new');
            Route::get('edit/{id}', 'FotoGalleryController@newOrEditForm')->name('admin.gallery.edit');
            Route::post('save/{id}', 'FotoGalleryController@save')->name('admin.gallery.save');
            Route::get('delete/{id}', 'FotoGalleryController@delete')->name('admin.gallery.delete');
            Route::get('deleteGalleryImage/{id}', 'FotoGalleryController@deleteGalleryImage')->name('admin.gallery.image.delete');
        });
        //----- Admin/Content/..
        Route::group(['prefix' => 'content/'], function () {
            Route::get('/', 'ContentController@index')->name('admin.content');
            Route::get('new', 'ContentController@create')->name('admin.content.new');
            Route::get('{content:id}', 'ContentController@create')->name('admin.content.edit');
            Route::post('{content:id}', 'ContentController@save')->name('admin.content.save');
            Route::delete('{content:id}', 'ContentController@delete')->name('admin.content.delete');
        });
        //----- Admin/Roles/..
        Route::group(['prefix' => 'roles/'], function () {
            Route::get('/', 'RoleController@list')->name('admin.roles');
            Route::get('new', 'RoleController@newOrEditForm')->name('admin.role.new');
            Route::get('edit/{id}', 'RoleController@newOrEditForm')->name('admin.role.edit');
            Route::post('save/{id}', 'RoleController@save')->name('admin.role.save');
            Route::get('delete/{id}', 'RoleController@delete')->name('admin.role.delete');
        });
        //----- Admin/Blog/..
        Route::group(['prefix' => 'blog'], function () {
            Route::get('/', 'BlogController@index')->name('admin.blog');
            Route::get('new', 'BlogController@create')->name('admin.blog.new');
            Route::get('edit/{blog:id}', 'BlogController@edit')->name('admin.blog.edit');
            Route::put('{blog:id}', 'BlogController@update')->name('admin.blog.update');
            Route::post('', 'BlogController@store')->name('admin.blog.store');
            Route::delete('{blog:id}', 'BlogController@delete')->name('admin.blog.delete');
        });
        //----- Admin/OurTeam/..
        Route::group(['prefix' => 'our-team/'], function () {
            Route::get('/', 'OurTeamController@list')->name('admin.our_team');
            Route::get('new', 'OurTeamController@newOrEditForm')->name('admin.our_team.new');
            Route::get('edit/{id}', 'OurTeamController@newOrEditForm')->name('admin.our_team.edit');
            Route::post('save/{id}', 'OurTeamController@save')->name('admin.our_team.save');
            Route::get('delete/{id}', 'OurTeamController@delete')->name('admin.our_team.delete');
        });
        //----- Admin/EBulten/..
        Route::group(['prefix' => 'ebulten/'], function () {
            Route::get('/', 'EBultenController@list')->name('admin.ebulten');
            Route::get('delete/{id}', 'EBultenController@delete')->name('admin.ebulten.delete');
        });
        //----- Admin/Contact/..
        Route::group(['prefix' => 'contact/'], function () {
            Route::get('/', 'ContactController@list')->name('admin.contact');
            Route::get('ajax', 'ContactController@ajax')->name('admin.contact.ajax');
            Route::get('delete/{contact:id}', 'ContactController@delete')->name('admin.contact.delete');
        });
        //---- Admin/Locations/......
        Route::group(['prefix' => 'locations'], function () {
            Route::get('/countries', 'RegionController@countries')->name('regions.countries');
            Route::get('/state/{country:id}', 'RegionController@getStatesByCountry')->name('regions.states');
            Route::get('/neighborhoods/{state:id}', 'RegionController@getNeighborhoodByState')->name('regions.neighborhoods');
        });

        //----- Admin/Tables/..
        Route::group(['prefix' => 'tables/'], function () {
            Route::get('users', 'TableController@users')->name('admin.tables.users');
            Route::get('blogs', 'TableController@blogs')->name('admin.tables.blogs');
            Route::get('companies', 'TableController@companies')->name('admin.tables.companies');
            Route::get('categories', 'TableController@categories')->name('admin.tables.categories');
            Route::get('contents', 'TableController@contents')->name('admin.tables.contents');
            Route::get('banners', 'TableController@banners')->name('admin.tables.banners');
        });

        //----- Admin/Images/----
        Route::delete('images/{image:id}', [\App\Http\Controllers\Admin\ImageController::class, 'delete']);
    });
});

Route::get('/home', 'HomeController@index')->name('home');
