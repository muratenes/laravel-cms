<?php

/*
|--------------------------------------------------------------------------
| Web Admin Routes
|--------------------------------------------------------------------------
|
 */

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::redirect('', '/admin/giris/');
//    Route::match(['get', 'post'], 'giris', 'AuthController@login')->name('admin.login');
    Route::get('giris', 'AuthController@loginView')->name('admin.login');
    Route::post('giris', 'AuthController@login')->name('admin.login.post');
    Route::get('/clear_cache', 'AnasayfaController@cacheClear')->name('admin.clearCache');
    Route::group(['middleware' => ['admin', 'admin.module', 'role', 'admin.language', 'admin.counts', 'admin.data']], function () {
        Route::get('home', 'AnasayfaController@index')->name('admin.home_page');
        Route::get('contacts', 'AnasayfaController@contacts')->name('admin.contacts');
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

        //----- Admin/Admin/..
        Route::group(['prefix' => 'builder/'], function () {
            Route::get('edit', 'BuilderController@edit')->name('admin.builder.edit');
            Route::post('save', 'BuilderController@save')->name('admin.builder.save');

            // ajax
            Route::post('get-view-folders/{theme}', 'BuilderController@getAllFilesByTheme');
            Route::get('get-view-folders/{theme}/{folder}', 'BuilderController@getFilesByTheme');

            //----- Admin/builder/menus
            Route::group(['prefix' => 'menus/'], function () {
                Route::get('/', 'MenuController@index')->name('admin.builder.menus');
                Route::get('create', 'MenuController@create')->name('admin.builder.menus.new');
                Route::get('edit/{item:id}', 'MenuController@edit')->name('admin.builder.menus.edit');
                Route::put('update/{item:id}', 'MenuController@update')->name('admin.builder.menus.update');
                Route::post('store', 'MenuController@store')->name('admin.builder.menus.store');
                Route::get('delete/{item:id}', 'MenuController@destroy')->name('admin.builder.menus.delete');
            });
        });

        // Adverts
        Route::resource('adverts', 'AdvertController', ['as' => 'admin']);

        //----- Admin/Products/..
        Route::group(['prefix' => 'product/'], function () {
            Route::get('/', 'UrunController@listProducts')->name('admin.products');
            Route::get('new', 'UrunController@newOrEditProduct')->name('admin.product.new');
            Route::get('edit/{product_id}', 'UrunController@newOrEditProduct')->name('admin.product.edit');
            Route::post('save/{product_id}', 'UrunController@saveProduct')->name('admin.product.save');
            Route::get('delete/{product:id}', 'UrunController@deleteProduct')->name('admin.product.delete');

            // ajax
            Route::get('ajax', 'UrunController@ajax');
            Route::get('getAllProductsForSearch', 'UrunController@getAllProductsForSearchAjax');
            Route::get('deleteProductDetailById/{id}', 'UrunController@deleteProductDetailById')->name('deleteProductDetailById');
            Route::get('getProductDetailWithSubAttributes/{product_id}', 'UrunController@getProductDetailWithSubAttributes')->name('getProductDetailWithSubAttributes');
            Route::get('deleteProductVariant/{variant_id}', 'UrunController@deleteProductVariant')->name('deleteProductVariant');
            Route::get('deleteProductImage/{id}', 'UrunController@deleteProductImage')->name('deleteProductImage');
            Route::post('clone-for-language/{product:id}/{lang}', 'UrunController@cloneForLanguage')->name('admin.product.clone-for-language');

            Route::group(['prefix' => 'attributes/'], function () {
                Route::get('/', 'UrunOzellikController@list')->name('admin.product.attribute.list');
                Route::get('new', 'UrunOzellikController@detail')->name('admin.product.attribute.new');
                Route::get('edit/{id}', 'UrunOzellikController@detail')->name('admin.product.attribute.edit');
                Route::post('update/{attribute:id}', 'UrunOzellikController@save')->name('admin.product.attribute.save');
                Route::post('create', 'UrunOzellikController@create')->name('admin.product.attribute.create');
                Route::get('delete/{id}', 'UrunOzellikController@delete')->name('admin.product.attribute.delete');

                // ajax
                Route::get('get-sub-attributes-by-attribute-id/{id}', 'UrunOzellikController@getSubAttributesByAttributeId')->name('getSubAttributesByAttributeId');
                Route::get('get-all-product-attributes', 'UrunOzellikController@getAllProductAttributes')->name('getAllProductAttributes');

                Route::post('deleteSubAttribute/{id}', 'UrunOzellikController@deleteSubAttribute')->name('admin.product.attribute.subAttribute.delete');
                Route::post('get-new-product-sub-attribute-html', 'UrunOzellikController@addNewProductSubAttribute');
            });

            //----- Admin/product/category -----
            Route::group(['prefix' => 'category/'], function () {
                Route::get('/', 'KategoriController@listCategories')->name('admin.product.categories');
                Route::get('new', 'KategoriController@newOrEditCategory')->name('admin.product.category.new');
                Route::get('edit/{category_id}', 'KategoriController@newOrEditCategory')->name('admin.product.category.edit');
                Route::post('save/{category_id}', 'KategoriController@saveCategory')->name('admin.product.category.save');
                Route::get('delete/{category_id}', 'KategoriController@deleteCategory')->name('admin.product.category.delete');
                // ajax
                Route::get('getSubCategoriesByCategoryId/{categoryID}', 'KategoriController@getSubCategoriesByID')->name('admin.category.get-sub-categories');
                Route::post('clone-for-language/{category:id}/{lang}', 'KategoriController@cloneForLanguage')->name('admin.category.clone-for-language');
                Route::post('sync-all-categories', 'KategoriController@syncParentCategoriesLanguages');
            });
            Route::group(['prefix' => 'comments/'], function () {
                Route::get('/', 'UrunYorumController@list')->name('admin.product.comments.list');
                Route::get('new', 'UrunYorumController@detail')->name('admin.product.comments.new');
                Route::get('edit/{id}', 'UrunYorumController@detail')->name('admin.product.comments.edit');
                Route::post('save/{id}', 'UrunYorumController@save')->name('admin.product.comments.save');
                Route::get('delete/{id}', 'UrunYorumController@delete')->name('admin.product.comments.delete');
            });
            Route::group(['prefix' => 'brands/'], function () {
                Route::get('/', 'UrunMarkaController@list')->name('admin.product.brands.list');
                Route::get('new', 'UrunMarkaController@detail')->name('admin.product.brands.new');
                Route::get('edit/{id}', 'UrunMarkaController@detail')->name('admin.product.brands.edit');
                Route::post('save/{id}', 'UrunMarkaController@save')->name('admin.product.brands.save');
                Route::get('delete/{id}', 'UrunMarkaController@delete')->name('admin.product.brands.delete');
            });
            Route::group(['prefix' => 'company/'], function () {
                Route::get('/', 'UrunFirmaController@list')->name('admin.product.company.list');
                Route::get('new', 'UrunFirmaController@detail')->name('admin.product.company.new');
                Route::get('edit/{id}', 'UrunFirmaController@detail')->name('admin.product.company.edit');
                Route::post('save/{id}', 'UrunFirmaController@save')->name('admin.product.company.save');
                Route::get('delete/{id}', 'UrunFirmaController@delete')->name('admin.product.company.delete');
            });
        });

        //----- Admin/Orders/..
        Route::group(['prefix' => 'order/'], function () {
            Route::get('/', 'SiparisController@list')->name('admin.orders');
            Route::get('/iyzico-fails', 'IyzicoController@iyzicoErrorOrderList')->name('admin.orders.iyzico_logs');
            Route::get('/iyzico-fails/{id}', 'IyzicoController@iyzicoErrorOrderDetail')->name('admin.orders.iyzico_logs_detail');
            Route::get('snapshot/{order:id}', 'SiparisController@snapshot')->name('admin.orders.snapshot');
            Route::get('edit/{orderId}', 'SiparisController@newOrEditOrder')->name('admin.order.edit');
            Route::post('save/{orderId}', 'SiparisController@save')->name('admin.order.save');
            Route::get('delete/{id}', 'SiparisController@deleteOrder')->name('admin.order.delete');

            // iyzico cancel
            Route::post('cancel-all/{order:id}', 'SiparisController@cancelOrder')->name('admin.order.cancel');
            Route::post('cancel-order-item/{item:id}', 'SiparisController@cancelOrderItem')->name('admin.orders.cancel-order-item');

            // iyzico refund items
            Route::post('refund-item', 'SiparisController@refundItem')->name('admin.orders.refund-basket-item');

            Route::get('edit/{order:id}/invoice', 'SiparisController@invoiceDetail')->name('admin.order.invoice');
            Route::get('ajax', 'SiparisController@ajax')->name('admin.order.ajax');

            Route::post('basket/{basketID}', 'BasketController@show');
        });

        //----- Admin/Banners/..
        Route::group(['prefix' => 'banner/'], function () {
            Route::get('/', 'BannerController@list')->name('admin.banners');
            Route::get('new', 'BannerController@newOrEditForm')->name('admin.banners.new');
            Route::get('edit/{id}', 'BannerController@newOrEditForm')->name('admin.banners.edit');
            Route::post('save/{id}', 'BannerController@save')->name('admin.banners.save');
            Route::get('delete/{id}', 'BannerController@delete')->name('admin.banners.delete');
        });

        //----- Admin/Configs/..
        Route::group(['prefix' => 'configs/'], function () {
            Route::get('list', 'AyarlarController@list')->name('admin.config.list');
            Route::get('show/{id}', 'AyarlarController@show')->name('admin.config.show');
            Route::post('save/{id}', 'AyarlarController@save')->name('admin.config.save');

            Route::resource('cargo', 'CargoController', ['as' => 'admin']);
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
            Route::get('/', 'KuponController@list')->name('admin.coupons');
            Route::get('new', 'KuponController@newOrEditForm')->name('admin.coupons.new');
            Route::get('edit/{id}', 'KuponController@newOrEditForm')->name('admin.coupons.edit');
            Route::post('save/{id}', 'KuponController@save')->name('admin.coupons.save');
            Route::get('delete/{id}', 'KuponController@delete')->name('admin.coupons.delete');
        });

        //----- Admin/Campaigns/..
        Route::group(['prefix' => 'campaigns/'], function () {
            Route::get('/', 'KampanyaController@list')->name('admin.campaigns');
            Route::get('new', 'KampanyaController@newOrEditForm')->name('admin.campaigns.new');
            Route::get('edit/{id}', 'KampanyaController@newOrEditForm')->name('admin.campaigns.edit');
            Route::post('save/{id}', 'KampanyaController@save')->name('admin.campaigns.save');
            Route::get('delete/{id}', 'KampanyaController@delete')->name('admin.campaigns.delete');
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
            Route::get('/', 'ReferansController@list')->name('admin.reference');
            Route::get('new', 'ReferansController@newOrEditForm')->name('admin.reference.new');
            Route::get('edit/{id}', 'ReferansController@newOrEditForm')->name('admin.reference.edit');
            Route::post('save/{id}', 'ReferansController@save')->name('admin.reference.save');
            Route::get('delete/{id}', 'ReferansController@delete')->name('admin.reference.delete');
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
            Route::get('new', 'ContentController@newOrEditForm')->name('admin.content.new');
            Route::get('{content:id}', 'ContentController@newOrEditForm')->name('admin.content.edit');
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
        //----- Admin/BlogCategory/..
        Route::group(['prefix' => 'blog-category'], function () {
            Route::get('/', 'BlogCategoryController@list')->name('admin.blog_category');
            Route::get('new', 'BlogCategoryController@newOrEdit')->name('admin.blog_category.new');
            Route::get('edit/{id}', 'BlogCategoryController@newOrEdit')->name('admin.blog_category.edit');
            Route::post('save/{id}', 'BlogCategoryController@save')->name('admin.blog_category.save');
            Route::get('delete/{BlogCategory:id}', 'BlogCategoryController@delete')->name('admin.blog_category.delete');
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
        });

        //----- Admin/Images/----
        Route::delete('images/{image:id}', [\App\Http\Controllers\Admin\ImageController::class, 'delete']);
    });
});

Route::get('/home', 'AnasayfaController@index')->name('home');
