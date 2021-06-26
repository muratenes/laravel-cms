<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Ayar;
use App\Models\KullaniciAdres;
use App\Models\Log;
use App\Models\Sepet;
use App\Models\SepetUrun;
use App\Models\Siparis;
use App\Models\İyzicoFailsJson;
use App\Repositories\Interfaces\OdemeInterface;
use App\User;

class ElOdemeDal extends BaseRepository implements OdemeInterface
{
    protected $model;

    public function __construct(Log $model)
    {
        parent::__construct($model);
    }

    public function getIyzicoInstallmentCount($creditCartNumber, $totalPrice)
    {
        // create request class
        $options = $this->getIyzicoOptions();
        $request = new \Iyzipay\Request\RetrieveInstallmentInfoRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId('123123');
        $request->setBinNumber($creditCartNumber);
        $request->setPrice($totalPrice);

        return \Iyzipay\Model\InstallmentInfo::retrieve($request, $options);
    }

    public function getIyzicoOptions()
    {
        $options = new \Iyzipay\Options();
        $options->setApiKey(env('IYZIPAY_API_KEY'));
        $options->setSecretKey(env('IYZIPAY_SECRET_KEY'));
        $options->setBaseUrl('https://sandbox-api.iyzipay.com');

        return $options;
    }

    /**
     * @param Siparis        $order
     * @param Sepet          $basket
     * @param array          $cardInfo       - kredi kartı bilgileri cvv,holderName,cardNumber,cardExpireDateMonth,cardExpireDateYear
     * @param User           $user
     * @param KullaniciAdres $invoiceAddress
     * @param KullaniciAdres $address
     *
     * @return array
     */
    public function makeIyzicoPayment(Siparis $order, Sepet $basket, array $cardInfo, User $user, KullaniciAdres $invoiceAddress, KullaniciAdres $address)
    {
        $options = $this->getIyzicoOptions();
        $request = new \Iyzipay\Request\CreatePaymentRequest();
        $request->setLocale(Ayar::LANG_TR === currentCurrencyID() ? 'tr' : 'en');
        $request->setConversationId($basket->id);
        $request->setPrice($basket->total);
        $request->setPaidPrice($basket->total); // todo : order price gelmesi gerek
        $request->setCurrency(Ayar::getCurrencyIyzicoConstById($order->currency_id));
        $request->setInstallment($order->installment_count);
        $request->setBasketId($basket->id);
        $request->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        // credit cart
        $paymentCard = new \Iyzipay\Model\PaymentCard();
        $paymentCard->setCardHolderName($cardInfo['holderName']);
        $paymentCard->setCardNumber(str_replace('-', '', $cardInfo['cardNumber']));
        $paymentCard->setExpireMonth($cardInfo['cardExpireDateMonth']);
        $paymentCard->setExpireYear($cardInfo['cardExpireDateYear']);
        $paymentCard->setCvc($cardInfo['cvv']);
        $paymentCard->setRegisterCard(0);
        $request->setPaymentCard($paymentCard);
        // buyer information
        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId($user->id);
        $buyer->setName($user->name);
        $buyer->setSurname($user->surname);
        $buyer->setGsmNumber($user->phone);
        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber('74300864791'); //tc kimlik gelicek
        $buyer->setRegistrationAddress($order->adres);
        $buyer->setIp($order->ip_adres);
        $buyer->setCity($address->state->title); // todo : city state buglar
        $buyer->setCountry($address->country->title); // todo : ülke string gelecek
        $buyer->setZipCode('34732');
        $request->setBuyer($buyer);
        // shipping address
        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName($address->full_name);
        $shippingAddress->setCity($address->state->title);
        $shippingAddress->setCountry($address->country->title);
        $shippingAddress->setAddress($order->adres);
        $shippingAddress->setZipCode('34742');
        $request->setShippingAddress($shippingAddress);
        // billing address
        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($invoiceAddress->full_name);
        $billingAddress->setCity($invoiceAddress->state->title);
        $billingAddress->setCountry($invoiceAddress->country->title);
        $billingAddress->setAddress($order->fatura_adres);
        $billingAddress->setZipCode('34742');
        $request->setBillingAddress($billingAddress);
        // basket items
        $basketItems = [];
        foreach ($basket->basket_items as $item) {
            $basketItem = new \Iyzipay\Model\BasketItem();
            $basketItem->setId($item->id);
            $basketItem->setName($item->product->title);
            $basketItem->setCategory1(config('admin.product.multiple_category') ? $item->product->categories->first()->title : $item->product->parent_category->title);
            $basketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
            $basketItem->setPrice($item->total);
            $basketItems[] = $basketItem;
        }
        $request->setBasketItems($basketItems);
        $request->setCallbackUrl(route('odeme.threeDSecurityResponse'));
        // todo : kredi kartı bilgilerini sil
        Log::addIyzicoLog('makeIyzicoPayment request atıldı', json_encode($request->getJsonObject()), $basket->id);
        $response = \Iyzipay\Model\ThreedsInitialize::create($request, $options);
        Log::addIyzicoLog('makeIyzicoPayment response alındı', $response->getRawResult(), $basket->id);

        return json_decode($response->getRawResult(), true);
    }

    public function logPaymentError($paymentResult, $order)
    {
        try {
            $paymentResult = json_decode($paymentResult, \JSON_UNESCAPED_UNICODE);
            // todo : genel logu kullan
            İyzicoFailsJson::addLog(auth()->user()->id, $order['full_name'], $order['sepet_id'], $paymentResult);
        } catch (\Exception $exception) {
            Log::addLog('iyzico işlemi sırasında hata oldu' . $exception->getMessage(), $exception, Log::TYPE_IYZICO);
        }
    }

    /**
     * 3d işlemini tamamlamak için kullanılır.
     *
     * @param $conversationId
     * @param int $paymentId
     *
     * @return array|false
     */
    public function completeIyzico3DSecurityPayment($conversationId, $paymentId)
    {
        try {
            $request = new \Iyzipay\Request\CreateThreedsPaymentRequest();
            $request->setLocale(\Iyzipay\Model\Locale::TR);
            $request->setConversationId($conversationId);
            $request->setPaymentId($paymentId);
            $response = \Iyzipay\Model\ThreedsPayment::create($request, $this->getIyzicoOptions());
            Log::addLog('3D bitirme response', $response->getRawResult(), Log::TYPE_IYZICO);
            $response = json_decode($response->getRawResult(), true);
            if ('success' === $response['status']) {
                foreach ($response['itemTransactions'] as $item) {
                    SepetUrun::where('id', $item['itemId'])->update([
                        'payment_transaction_id' => $item['paymentTransactionId'],
                        'paid_price'             => $item['paidPrice'],
                    ]);
                }
            }

            return $response;
        } catch (\Exception $exception) {
            Log::addLog('iyzico 3d tamamlama sırasında hata oldu' . $exception->getMessage(), $exception, Log::TYPE_IYZICO);

            return false;
        }
    }

    /**
     * kullanıcının ödemesi tamamlanmamış siparişleri siliniyor.
     *
     * @param $userId
     */
    public function deleteUserOldNotPaymentOrderTransactions($userId)
    {
        Siparis::where('is_payment', 0)->whereHas('basket', function ($query) use ($userId) {
            $query->user_id = $userId;
        })->forceDelete();
    }
}
