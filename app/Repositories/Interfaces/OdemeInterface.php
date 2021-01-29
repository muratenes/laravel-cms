<?php namespace App\Repositories\Interfaces;

use App\User;
use App\Models\KullaniciAdres;
use App\Models\Sepet;
use App\Models\Siparis;

interface OdemeInterface
{
    public function getIyzicoInstallmentCount($creditCartNumber, $totalPrice);

    public function getIyzicoOptions();

    public function makeIyzicoPayment(Siparis $order, Sepet $basket, array $cardInfo, User $user, KullaniciAdres $invoiceAddress, KullaniciAdres $address);

    public function logPaymentError($paymentResult, $order);

    public function completeIyzico3DSecurityPayment($conversationId, $paymentId);

    public function deleteUserOldNotPaymentOrderTransactions($userId);

}
