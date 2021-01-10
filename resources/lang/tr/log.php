<?php

return [

    //========= ADMIN ================
    'admin' =>[
        // Cancel Order
        'error_when_order_cancel' => 'Admin iptal işlemi sırasında hata oluştu',
        'order_successfully_cancelled_from_admin' => 'Sipariş admin tarafından başarılı şekilde iptal edildi',
        'order_successfully_cancelled_message' => 'Sipariş başarılı şekilde iade edildi paranın alıcıya geçmesi bankaya  göre değişiklik gösterebilir',

        // Refund Order Item
        'order_item_successfully_refunded_message' => 'ID : :id olan ürün için admin tarafından :refundAmount iade edildi',
        'basket_item_refund_error' => 'basket item:{itemId} için iade işlemi başarısız  :message'
    ],

];
