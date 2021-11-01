<?php

// test

//Route::get('mailable', function () {
//    $invoice = App\Models\Siparis::find(9);
//
//    return new App\Mail\Order\OrderCreateadMail($invoice);
//});
// todo : kullanici işlemleri için throotle ekle

Route::group(['middleware' => 'site.config'], function () {
//social auth
    Route::get('/redirect/{service}', 'SocialAuthController@redirect');
    Route::get('/callback/{service}', 'SocialAuthController@callback');

    Route::get('test', 'TestController@index');
    // İnitial routes
    Route::get('kurumsal', 'AnasayfaController@about')->name('about');
    Route::get('iletisim', 'IletisimController@index')->name('contact');
    Route::post('iletisim', 'IletisimController@sendMail')->name('contact.post')->middleware(['throttle:3,10']);
    Route::get('sss', 'SSSController@list')->name('sss');
    Route::post('referanslar', 'ReferenceController@list')->name('referanslar');
    Route::post('{content:slug}', 'IcerikYonetimController@detail')->name('content.detail');
    Route::post('referanslar/{reference:slug}', 'ReferenceController@detail')->name('referanslar.detail');
    Route::get('galeri', 'GaleriController@detail')->name('gallery.list');
    Route::get('galeri/{gallery:slug}', 'GaleriController@detail')->name('gallery.detail');
    Route::get('haberler', 'BlogController@list')->name('blog.list');
    Route::get('haberler/{blog:slug}', 'BlogController@detail')->name('blog.detail');
    Route::post('createBulten', 'EBultenController@createEBulten')->name('ebulten.create')->middleware(['throttle:3,10']);

    Route::get('/', 'AnasayfaController@index')->name('homeView');
    Route::get('/sitemap.xml', 'AnasayfaController@sitemap');
    Route::get('/ara', 'AramaController@ara')->name('searchView');
    Route::get('/searchPageFilter', 'AramaController@searchPageFilterWithAjax');
    Route::get('/headerSearchBarOnChangeWithAjax', 'AramaController@headerSearchBarOnChangeWithAjax');

    //------------Ajax Routes --------------------
    Route::post('check-product-variant/{product:id}', 'UrunController@checkProductVariant')->name('getProductVariantPriceAndQtyWithAjax');
    Route::get('productFilterWithAjax', 'KategoriController@productFilterWithAjax')->name('productFilterWithAjax');

    //------------- Basket Routes --------------------

    Route::group(['prefix' => 'sepet', 'middleware' => 'throttle:20'], function () {
        Route::get('', 'SepetController@index')->name('basket');
        Route::post('/ekle', 'SepetController@itemAddToBasket')->name('basket.add');
        Route::delete('/sil/{rowId}', 'SepetController@remove')->name('basket.remove');
        Route::delete('/tumunu-kaldir', 'SepetController@clearBasket')->name('basket.removeAllItems');

        // Ajax
        Route::post('/addToBasket/{product:id}', 'SepetController@addItem')->name('basket.add.ajax');
        Route::post('/removeBasketItem/{rowId}', 'SepetController@removeItemFromBasketWithAjax')->name('basket.remove.ajax');
        Route::post('/decrement/{rowId}', 'SepetController@decrement');
        Route::post('/multiple-update', 'SepetController@updateMultipleBasketItem');
    });

    //------------ Odeme Controller -------------------
    Route::group(['prefix' => 'odeme/', 'middleware' => ['auth', 'throttle:20']], function () {
        Route::get('adres', 'AddressController@addresses')->name('odeme.adres');
        Route::get('review', 'OdemeController@index')->name('odemeView');
        Route::post('review', 'OdemeController@payment')->name('payment.create');
        Route::get('taksit-getir', 'OdemeController@getIyzicoInstallmentCount')->name('odgetIyzicoInstallmentCount');

        Route::get('threeDSecurityRequest', 'OdemeController@threeDSecurityRequest')->name('odeme.threeDSecurityRequest');
        Route::post('threeDSecurityResponse', 'OdemeController@threeDSecurityResponse')->name('odeme.threeDSecurityResponse');
    });

    //---------- User Routes ----------------------
    Route::group(['prefix' => 'kullanici'], function () {
        Route::get('/giris', 'KullaniciController@loginForm')->name('user.login');
        Route::post('/giris', 'KullaniciController@login');
        Route::post('/cikis', 'KullaniciController@logout')->name('user.logout');
        Route::get('/kayit', 'KullaniciController@registerForm')->name('user.register');
        Route::post('/kayit', 'KullaniciController@register')->middleware('throttle:10');
        Route::get('/aktiflestir/{activation_code}', 'KullaniciController@activateUser');

        Route::group(['middleware' => 'auth'], function () {
            Route::get('siparisler', 'SiparisController@index')->name('user.orders');
            Route::get('siparisler/{order:id}', 'SiparisController@detail')->name('user.orders.detail')->middleware('can:edit-order,order');

            Route::get('adresler', 'AddressController@addresses')->name('user.addresses');
            Route::get('adres/{addressID}', 'AddressController@detail')->name('user.address.edit');
            Route::post('adres/{addressID}', 'AddressController@save')->name('user.address.save');
            Route::post('setDefaultAddress/{address:id}', 'AddressController@setDefaultAddress')->name('user.address.setDefault')->middleware('can:edit-address,address');
            Route::post('setDefaultInvoiceAddress/{address:id}', 'AddressController@setDefaultInvoiceAddress')->name('user.address.set-default-invoice-address')->middleware('can:edit-address,address');
            Route::delete('address/{address:id}', 'AddressController@delete')->name('user.address.delete')->middleware('can:edit-address,address');

            Route::get('profil', 'AccountController@userDetail')->name('user.detail');
            Route::post('profil', 'AccountController@userDetailSave')->name('user.detail');
            Route::get('hesabim', 'AccountController@dashboard')->name('user.dashboard');
            Route::get('favorilerim', 'FavoriController@list')->name('user.favorites');
            Route::post('favoriler/{product:id}', 'FavoriController@addToFavorites');
            Route::delete('favoriler/{product:id}', 'FavoriController@delete')->name('user.favorites.delete');
        });
    });
    Route::group(['prefix' => 'locations'], function () {
        Route::get('/getTownsByCityId/{cityId}', 'CityTownController@getTownsByCityId')->name('cityTownService.getTownsByCityId');
    });

    //Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');

    // Coupon code
    Route::post('kupon/uygula', 'KuponController@applyCoupon')->name('coupon.apply');

    // Favorites Route
    Route::post('favoriler/ekle', 'FavoriController@addToFavorites');
    Route::get('favoriler/listele', 'FavoriController@listAnonimUserFavorites')->name('favoriler.anonimList');

    // campaigns Route
    Route::get('kampanyalar', 'KampanyaController@list')->name('campaigns.list');
    Route::get('kampanyalar/{slug}', 'KampanyaController@detail')->name('campaigns.detail');
    Route::get('kampanyalar/{slug}/{category}', 'KampanyaController@detail')->name('campaigns.detail');
    Route::get('campaignsFilterWithAjax', 'KampanyaController@campaignsFilterWithAjax')->name('campaigns.filterWithAjax');

    Route::get('lang/{locale}', 'AnasayfaController@setLanguage')->name('home.setLocale');
    // ------------Product Routes ----------------
    Route::get('{product:slug}', 'UrunController@detail')->name('product.detail');
    Route::get('urun/quickView/{product:slug}', 'UrunController@quickView')->name('product.quickView');
    Route::get('kategori/{categorySlug}', 'KategoriController@index')->name('category.detail');
    Route::post('product/add-comment/{product:id}', 'UrunController@createComment')->name('product.comments.add')->middleware('auth');
});
