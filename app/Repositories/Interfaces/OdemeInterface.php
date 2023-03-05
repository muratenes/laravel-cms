<?php

namespace App\Repositories\Interfaces;

use App\Models\Basket;
use App\Models\Order;
use App\Models\UserAddress;
use App\User;

interface OdemeInterface
{
    public function getIyzicoInstallmentCount($creditCartNumber, $totalPrice);

    public function getIyzicoOptions();

    public function makeIyzicoPayment(Order $order, Basket $basket, array $cardInfo, User $user, UserAddress $invoiceAddress, UserAddress $address);

    public function logPaymentError($paymentResult, $order);

    public function completeIyzico3DSecurityPayment($conversationId, $paymentId);

    public function deleteUserOldNotPaymentOrderTransactions($userId);
}
