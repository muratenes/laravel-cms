<?php

namespace App\Utils\Concerns\Controllers;

use App\Models\KullaniciAdres;
use App\Models\Log;
use App\Models\Product\Urun;
use App\Models\Product\UrunVariant;
use App\Models\Sepet;
use App\Models\Siparis;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait PaymentConcern
{
    /**
     *  kullanıcının invoice adresini gönderir kullanıcı farklı invoice eklemek isterse ekler
     *  yoksa param olarak gönderilen getirir.
     *
     * @param Request        $request
     * @param User           $user
     * @param KullaniciAdres $defaultAddress
     *
     * @return mixed
     */
    protected function getOrCreateInvoiceAddress(Request $request, User $user, KullaniciAdres $defaultAddress)
    {
        $invoiceAddress = $this->accountService->getUserDefaultInvoiceAddress($user->id);
        if ($request->has('differentBillAddress')) {
            $invoiceAddressData = array_merge($request->only('title', 'name', 'surname', 'phone', 'state_id', 'district_id', 'adres'), [
                'type' => KullaniciAdres::TYPE_INVOICE,
            ]);
            $invoiceAddress = $user->addresses()->create($invoiceAddressData);
            $this->accountService->checkUserDefaultAddress($user, $invoiceAddress);
        }

        return $invoiceAddress ? $invoiceAddress : $defaultAddress;
    }

    /**
     * @param KullaniciAdres $invoiceAddress
     * @param KullaniciAdres $defaultAddress
     * @param Sepet          $basket
     *
     * @return Siparis
     */
    protected function createOrderFromRequest(KullaniciAdres $invoiceAddress, KullaniciAdres $defaultAddress, Sepet $basket)
    {
        $validated = request()->only('taksit_sayisi', 'cardNumber', 'holderName', 'cardExpireDateMonth', 'cardExpireDateYear', 'ccv');

        $order = Siparis::create([
            'sepet_id'            => $basket->id,
            'phone'               => $defaultAddress->phone,
            'installment_count'   => $validated['taksit_sayisi'] ?? 1,
            'status'              => Siparis::STATUS_3D_BASLATILDI,
            'order_price'         => $basket->sub_total,
            'cargo_price'         => $basket->cargo_total,
            'coupon_price'        => $basket->coupon_price,
            'order_total_price'   => $basket->total,
            'ip_adres'            => request()->ip(),
            'adres'               => $defaultAddress->address_text,
            'fatura_adres'        => $invoiceAddress->address_text,
            'full_name'           => "{$defaultAddress->name}  {$defaultAddress->surname}",
            'currency_id'         => currentCurrencyID(),
            'hash'                => Str::uuid(),
            'email'               => $defaultAddress->email,
            'order_note'          => request()->get('order_note'),
            'full_name_invoice'   => $invoiceAddress->full_name,
            'phone_invoice'       => $invoiceAddress->phone,
            'email_invoice'       => $invoiceAddress->email,
            'delivery_address_id' => $defaultAddress->id,
            'invoice_address_id'  => $invoiceAddress->id,
        ]);

        $this->takeSnapshot($order);

        Log::addIyzicoLog('Sipariş Oluşturuldu', "order id : {$order->id}", $basket->id);
        session()->put('orderId', $order->id);

        return $order;
    }

    /**
     * iyzico kredi kartı bilgilerini gönderir.
     *
     * @param $request
     *
     * @return array
     */
    protected function getCardInfoFromRequest(Request $request)
    {
        return $request->only([
            'holderName',
            'cardNumber',
            'cardExpireDateMonth',
            'cardExpireDateYear',
            'cvv',
        ]);
    }

    /**
     * ödeme işleminden sonra varyanta bakar ve stok durumunu günceller.
     *
     * @param int        $productID
     * @param int        $qty                satın alınan ürün adet
     * @param int        $currencyID         para birimi id
     * @param null|array $subAttributeIdList ürün sub attribute id listesi
     */
    protected function checkProductVariantAndDecrementQty(int $productID, int $qty, $currencyID, ?array $subAttributeIdList)
    {
        $variant = UrunVariant::urunHasVariant($productID, $subAttributeIdList, $currencyID);
        if ($variant) {
            $variant->decrement('qty', $qty);
        } else {
            Urun::find($productID)->decrement('qty', $qty);
        }
    }

    /**
     * sipariş oluşturma esnasında gerekli bilgileri json olarak alır.
     *
     * @param Siparis $order
     */
    private function takeSnapshot(Siparis $order)
    {
        $order = Siparis::with(['basket.basket_items.product', 'basket.user'])->find($order->id);
        $order->basket->setAppends(['total', 'sub_total', 'cargo_total', 'coupon_price']);
        foreach ($order->basket->basket_items as $basketItem) {
            $basketItem->setAppends(['total', 'sub_total', 'cargo_total']);
        }
        $orderArray = $order->toArray();
        unset($orderArray['snapshot']);
        $order->update(['snapshot' => $orderArray]);
    }
}
