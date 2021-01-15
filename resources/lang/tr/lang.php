<?php
// Türkçe Dil Dosyası
return [
    'welcome' => 'Sitemize Hoşgeldin',
    'contact' => 'İletişim',
    'home' => 'Anasayfa',

    'an_error_occurred_during_the_process' => 'An error occurred during the process',
    'success_message' => "İşlem başarılı şekilde gerçekleşti",
    'error_message' => "İşlem sırasında bir hata oluştu",

    // Odeme
    'you_must_be_login_for_payment' => 'Ödeme yapmak için oturum açmanız veya üye olmanız gerekmektedir',
    'there_is_no_item_in_your_cart_to_checkout' => 'Ödeme yapmak için sepetinizde bir ürün bulunamadı',
    'no_address_information_is_entered_selected_please_add_or_select_a_new_address_below' => 'Adres bilgisi girilmedi / seçilmedi, lütfen aşağıdan yeni bir adres ekleyin veya seçin.',
    'no_order_found_to_pay' => 'ödeme yapmak için herhangi bir siparişiniz bulunamadı',
    'the_order_has_been_received_successfully' => 'Sipariş başarılı şekilde alındı.',

    // Kullanıcı
    'welcome_to_app' => 'Hoşgeldin Giriş Başarılı',
    'wrong_username_or_password' => 'hatalı kullanıcı adı veya şifre kontrol ediniz',
    'please_verify_email_for_active_account' => 'kullanıcı kaydınızı aktifleştirmek için lütfen mail adresinizi kontrol ediniz ve aktivasyonu gerçekleştiriniz',

    // Ebulten
    'congratulations_you_have_successfully_registered_for_the_newsletter' => 'Tebrikler ebültene başarılı şekilde kaydoldunuz',


    //=============== Email ===============
    'hello' => 'Merhaba',
    'order_code' => 'Sipariş Kodu',
    'order_date' => 'Sipariş Tarihi',
    'product' => 'Ürün',
    'price' => 'Fiyat',
    'status' => 'Durum',
    'qty' => 'Adet',
    'cargo_price' => 'Kargo Fiyatı',
    'total' => 'Toplam',
    'product_total' => 'Ürün Toplam',
    'total_amount' => 'Toplam Tutar',
    'coupon_total' => 'Kupon Toplam',
    'sub_total' => 'Alt Toplam',
    'coupon' => 'Kupon',
    'delivery_address' => 'Teslimat Adresi',
    'invoice_address' => 'Fatura Adresi',
    'hello_username' => 'Merhaba :username',
    'order_successfully_received' => 'siparişiniz başarılı şekilde alındı',

    //OrderItemStatusChangedNotify
    'order_item_status_changed' => ':product durumu ":status" olarak güncellendi',
    'show_order' => 'Siparişi Göster',

    // OrderStatusChangedNotification
    'order_status_changed' => 'Sipariş durumu :status olarak güncellendi',

    //OrderCancelledNotify
    'refund_information' => 'Geri Ödeme Bilgisi',
    'your_refund_has_been_processed_successfully' => 'İade işleminiz başarıyla gerçekleşti',
    'order_refund_text' => ":code no'lu siparişinizin iptal / değişim / iadesine istinaden :price TL'lik tutar, :date tarihinde ödeme yaptığınız bankaya tarafımızdan ödenmiştir.",
    'order_refund_bank_text' => 'Bankanızın bu tutarı kredi kartınıza/banka kartınıza yansıtma süresi :day iş günüdür. Bu süre banka tarafından belirlendiği için geri ödeme işlemiyle ilgili bankanızla iletişim kurmanızı tavsiye ederiz.',
    'order_can_not_cancel_basket_item' => 'Sipariş durumu ":status" olduğu için iptal edilemez',

    // PasswordReset Notification
    'you_are_receiving_this_email_because_we_have_received' => 'Bu e-postayı, hesabınız için bir şifre sıfırlama isteği aldığımız için alıyorsunuz.',
    'reset_password' => 'Parola Sıfırla',
    'if_you_have_not_requested_a_password_reset_ignore_this_email' => 'Parola sıfırlama isteğinde bulunmadıysanız, bu maili dikkate almayınız',

    // Sepet
    'can_not_cancel_basket_item' => 'Ürün durumu ":status" olduğu için iptal edilemez',
    'the_order_cannot_be_canceled_because_it_is_not_on_the_same_day' => 'Sipariş aynı gün olmadığı için yada saat geçtiği için iptal edilemez iade talebi oluşturunuz',
    'can_be_canceled' => 'İptal işlemi yapılabilir',
    'can_not_cancel_order' => 'Sipariş durumu :status olduğu için iptal edilemez',
    'you_can_not_refund_basket_item_two_week_error' => 'Sipariş üzerinden 14 gün geçtiği için iade talebi oluşturulamaz',
    'the_amount_refunded_cannot_be_greater_than_the_grand_total' => 'iade edilmek istenen tutar(:refunded_amount), ürününün genel toplamından büyük olamaz',
    'item_removed' => 'Ürün sepetten kaldırıldı',
    'removed_all_items' => 'Sepetteki tüm ürünler silindi',
    'only_qty_left_of_this_product' => " Yetersiz stok, bu üründen malesef :qty adet kaldı",
    'there_are_no_items_in_your_cart' => 'Sepetinizde ürün bulunamadı',
    'added_to_basket' => 'Sepete eklendi',
    'basket_item_not_found' => 'Ürün sepette bulunamadı',


    // İade
    'product_cancelled_with_amount' => '":product" ürünün :amount :currency değerinde iade işlemi başarılı şekilde gerçekleşti',

    // ===== Account =====
    'old_password_does_not_match' => 'Eski parolanız hatalı',
    'password_successfully_updated' => 'Parola başarılı şekilde güncellendi.',
    'profile_updated' => 'Profil başarıyla güncellendi',

    // Favoriler
    'product_removed_favorites' => 'Ürün favorilerimden kaldırıldı',

    // Yorum
    'you_have_already_added_comment' => 'Bu ürüne zaten yorum eklendi',
    'product_comment_added' => 'Yorum eklendi yönetici onayından sonra burada görüntülenecektir'


];
