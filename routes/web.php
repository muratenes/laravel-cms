<?php

Route::group(['middleware' => 'site.config'], function () {
    // social auth
    Route::get('/redirect/{service}', 'SocialAuthController@redirect');
    Route::get('/callback/{service}', 'SocialAuthController@callback');

    Route::get('test', 'TestController@index');
    // İnitial routes
    Route::get('kurumsal', 'HomeController@about')->name('about');
    Route::get('contact', 'ContactController@index')->name('contact');
    Route::post('contact', 'ContactController@sendMail')->name('contact.post')->middleware(['throttle:3,10']);
    Route::get('sss', 'SSSController@list')->name('sss');
    Route::post('referanslar', 'ReferenceController@list')->name('referanslar');
    Route::get('{content:slug}', 'ContentController@detail')->name('content.detail');
    Route::post('referanslar/{reference:slug}', 'ReferenceController@detail')->name('referanslar.detail');
    Route::get('galeri', 'GalleryController@detail')->name('gallery.list');
    Route::get('galeri/{gallery:slug}', 'GalleryController@detail')->name('gallery.detail');
    Route::get('haberler', 'BlogController@list')->name('blog.list');
    Route::get('haberler/{blog:slug}', 'BlogController@detail')->name('blog.detail');
    Route::post('createBulten', 'EBultenController@createEBulten')->name('ebulten.create')->middleware(['throttle:3,10']);

    Route::get('/', 'HomeController@index')->name('homeView');
    Route::get('/sitemap.xml', 'HomeController@sitemap');
    Route::get('/ara', 'SearchController@ara')->name('searchView');
    Route::get('/searchPageFilter', 'SearchController@searchPageFilterWithAjax');
    Route::get('/headerSearchBarOnChangeWithAjax', 'SearchController@headerSearchBarOnChangeWithAjax');

    // ------------Ajax Routes --------------------
    Route::post('check-product-variant/{product:id}', 'ProductController@checkProductVariant')->name('getProductVariantPriceAndQtyWithAjax');
    Route::get('productFilterWithAjax', 'CategoryController@productFilterWithAjax')->name('productFilterWithAjax');

    // ------------- Basket Routes --------------------

    Route::group(['prefix' => 'basket', 'middleware' => 'throttle:20'], function () {
        Route::get('', 'BasketController@index')->name('basket');
        Route::post('/ekle', 'BasketController@itemAddToBasket')->name('basket.add');
        Route::delete('/sil/{rowId}', 'BasketController@remove')->name('basket.remove');
        Route::delete('/tumunu-kaldir', 'BasketController@clearBasket')->name('basket.removeAllItems');

        // Ajax
        Route::post('/addToBasket/{product:id}', 'BasketController@addItem')->name('basket.add.ajax');
        Route::post('/removeBasketItem/{rowId}', 'BasketController@removeItemFromBasketWithAjax')->name('basket.remove.ajax');
        Route::post('/decrement/{rowId}', 'BasketController@decrement');
        Route::post('/multiple-update', 'BasketController@updateMultipleBasketItem');
    });

    // ------------ Odeme Controller -------------------
    Route::group(['prefix' => 'payment/', 'middleware' => ['auth', 'throttle:20']], function () {
        Route::get('adres', 'AddressController@addresses')->name('payment.adres');
        Route::get('review', 'PaymentController@index')->name('odemeView');
        Route::post('review', 'PaymentController@payment')->name('payment.create');
        Route::get('taksit-getir', 'PaymentController@getIyzicoInstallmentCount')->name('odgetIyzicoInstallmentCount');

        Route::get('threeDSecurityRequest', 'PaymentController@threeDSecurityRequest')->name('payment.threeDSecurityRequest');
        Route::post('threeDSecurityResponse', 'PaymentController@threeDSecurityResponse')->name('payment.threeDSecurityResponse');
    });

    // ---------- User Routes ----------------------
    Route::group(['prefix' => 'user'], function () {
        Route::get('/giris', 'UserController@loginForm')->name('user.login');
        Route::post('/giris', 'UserController@login');
        Route::post('/cikis', 'UserController@logout')->name('user.logout');
        Route::get('/kayit', 'UserController@registerForm')->name('user.register');
        Route::post('/kayit', 'UserController@register')->middleware('throttle:10');
        Route::get('/aktiflestir/{activation_code}', 'UserController@activateUser');

        Route::group(['middleware' => 'auth'], function () {
            Route::get('siparisler', 'OrderController@index')->name('user.orders');
            Route::get('siparisler/{order:id}', 'OrderController@detail')->name('user.orders.detail')->middleware('can:edit-order,order');

            Route::get('adresler', 'AddressController@addresses')->name('user.addresses');
            Route::get('adres/{addressID}', 'AddressController@detail')->name('user.address.edit');
            Route::post('adres/{addressID}', 'AddressController@save')->name('user.address.save');
            Route::post('setDefaultAddress/{address:id}', 'AddressController@setDefaultAddress')->name('user.address.setDefault')->middleware('can:edit-address,address');
            Route::post('setDefaultInvoiceAddress/{address:id}', 'AddressController@setDefaultInvoiceAddress')->name('user.address.set-default-invoice-address')->middleware('can:edit-address,address');
            Route::delete('address/{address:id}', 'AddressController@delete')->name('user.address.delete')->middleware('can:edit-address,address');

            Route::get('profil', 'AccountController@userDetail')->name('user.detail');
            Route::post('profil', 'AccountController@userDetailSave')->name('user.detail');
            Route::get('hesabim', 'AccountController@dashboard')->name('user.dashboard');
            Route::get('favorilerim', 'FavoriteController@list')->name('user.favorites');
            Route::post('favoriler/{product:id}', 'FavoriteController@addToFavorites');
            Route::delete('favoriler/{product:id}', 'FavoriteController@delete')->name('user.favorites.delete');
        });
    });
    Route::group(['prefix' => 'locations'], function () {
        Route::get('/getTownsByCityId/{cityId}', 'CityTownController@getTownsByCityId')->name('cityTownService.getTownsByCityId');
        Route::get('/getNeighByDistrict/{districtId}', 'CityTownController@getNeighByDistrictId');
    });

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');

    // Coupon code
    Route::post('kupon/uygula', 'CouponController@applyCoupon')->name('coupon.apply');

    // Favorites Route
    Route::post('favoriler/ekle', 'FavoriteController@addToFavorites');
    Route::get('favoriler/listele', 'FavoriteController@list')->name('favoriler.anonimList');

    // campaigns Route
    Route::get('kampanyalar', 'CampaignController@list')->name('campaigns.list');
    Route::get('kampanyalar/{slug}', 'CampaignController@detail')->name('campaigns.detail');
    Route::get('kampanyalar/{slug}/{category}', 'CampaignController@detail')->name('campaigns.detail');
    Route::get('campaignsFilterWithAjax', 'CampaignController@campaignsFilterWithAjax')->name('campaigns.filterWithAjax');

    Route::get('lang/{locale}', 'HomeController@setLanguage')->name('home.setLocale');
    // ------------Product Routes ----------------
    Route::get('{product:slug}', 'ProductController@detail')->name('product.detail');
    Route::get('product/quickView/{product:slug}', 'ProductController@quickView')->name('product.quickView');
    Route::get('kategori/{categorySlug}', 'CategoryController@index')->name('category.detail');
    Route::post('product/add-comment/{product:id}', 'ProductController@createComment')->name('product.comments.add')->middleware('auth');
});
