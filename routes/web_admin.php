<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Services\DashboardService;

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::redirect('', '/admin/giris/');
//    Route::match(['get', 'post'], 'giris', 'AuthController@login')->name('admin.login');
    Route::get('giris', 'AuthController@loginView')->name('admin.login');
    Route::post('giris', 'AuthController@login')->name('admin.login.post');
    Route::get('/clear_cache', 'HomeController@cacheClear')->name('admin.clearCache');
    Route::get('/init', [DashboardController::class, 'init']);
    Route::view('/add-new-order', 'admin.order.partials.add-new-order', (new DashboardService())->init());

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

            Route::post('create', [OrderController::class, 'createOrder'])->name('admin.order.create');
        });

        //----- Admin/Payments/..
        Route::group(['prefix' => 'payments/'], function () {
            Route::get('/', [PaymentController::class, 'list'])->name('admin.payments');
            Route::get('edit/{orderId}', 'PaymentController@newOrEditOrder')->name('admin.payments.edit');

            Route::get('ajax', [PaymentController::class, 'ajax'])->name('admin.payments.ajax');

            Route::post('create', [PaymentController::class, 'createPayment'])->name('admin.payments.create');
        });


        //----- Admin/Logs/..
        Route::group(['prefix' => 'logs/'], function () {
            Route::get('/', 'LogController@list')->name('admin.logs');
            Route::get('show/{id}', 'LogController@show')->name('admin.log.show');
            Route::get('json/{log:id}', 'LogController@json')->name('admin.log.json');
            Route::get('delete/{id}', 'LogController@delete')->name('admin.log.delete');
            Route::get('deleteAll', 'LogController@deleteAll')->name('admin.log.delete_all');
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
    });
});

Route::get('/home', 'HomeController@index')->name('home');
