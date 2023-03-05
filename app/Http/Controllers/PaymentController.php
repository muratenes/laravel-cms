<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentValidationRequest;
use App\Jobs\NewOrderAddedJob;
use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Config;
use App\Models\Iyzico;
use App\Models\Log;
use App\Models\Order;
use App\Models\İyzicoFailsJson;
use App\Repositories\Interfaces\AccountInterface;
use App\Repositories\Interfaces\CityTownInterface;
use App\Repositories\Interfaces\KuponInterface;
use App\Repositories\Interfaces\OdemeInterface;
use App\Repositories\Interfaces\SiparisInterface;
use App\Repositories\Traits\IyzicoTrait;
use App\Repositories\Traits\SepetSupportTrait;
use App\Utils\Concerns\Controllers\PaymentConcern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    use IyzicoTrait;
    use PaymentConcern;
    use SepetSupportTrait;

    private SiparisInterface $orderService;
    private OdemeInterface $paymentService;
    private CityTownInterface $cityTownService;
    private AccountInterface $accountService;
    private KuponInterface $couponService;

    public function __construct(SiparisInterface $orderService, OdemeInterface $paymentService, CityTownInterface $cityTownService, AccountInterface $accountService, KuponInterface $couponService)
    {
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
        $this->cityTownService = $cityTownService;
        $this->accountService = $accountService;
        $this->couponService = $couponService;
    }

    public function index(Request $request)
    {
        $basket = Basket::getCurrentBasket();
        $this->matchSessionCartWithBasketItems($basket);

        if (0 === $this->getBasketItemCount() || 0 === $basket->basket_items->count()) {
            return redirect()->route('homeView')->with('message', __('lang.there_is_no_item_in_your_cart_to_checkout'))->with('message_type', 'info');
        }

        if (! $request->user()->default_address) {
            error(__('lang.no_address_information_is_entered_selected_please_add_or_select_a_new_address_below'));

            return redirect()->route('payment.adres');
        }
        $address = $request->user()->default_address;
        $states = $this->cityTownService->all();
        $defaultInvoiceAddress = $request->user()->default_invoice_address;
        $owner = Config::getCache();

        if (session()->get('coupon')) {
            $this->couponService->checkCoupon($this->getProductIdList(), session()->get('coupon')['code'], $this->getCardSubTotal(), $basket->currency_id, $basket);
        }

        return view('site.payment.payment', compact('address', 'states', 'defaultInvoiceAddress', 'owner', 'basket'));
    }

    /**
     * ödeme işlemi başlatır.
     *
     * @param PaymentValidationRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payment(PaymentValidationRequest $request)
    {
        try {
            $user = $request->user();
            $currentBasket = Basket::getCurrentBasket();
            Log::addIyzicoLog('Ödeme işlemine başlandı', "basket id : {$currentBasket->id}", $currentBasket->id);
            \DB::beginTransaction();

            if (! $currentBasket->basket_items->count()) {
                return redirect(route('basket'))->withErrors(__('lang.there_are_no_items_in_your_cart'));
            }
            $defaultAddress = $this->accountService->getUserDefaultAddress($user->id);
            $invoiceAddress = $this->getOrCreateInvoiceAddress($request, $user, $defaultAddress);
            $order = $this->createOrderFromRequest($invoiceAddress, $defaultAddress, $currentBasket);

            $creditCartInfo = $this->getCardInfoFromRequest($request);
            $payment = $this->paymentService->makeIyzicoPayment($order, $currentBasket, $creditCartInfo, $currentBasket->user, $invoiceAddress, $defaultAddress);
            if ('success' === $payment['status']) {
                $iyzico3DResponse = $this->getIyzico3DSecurityDetailsFromIyzicoResponseData($payment);
                Session::put('conversationId', $iyzico3DResponse['conversationId']); // basket id
                Session::put('threeDSHtmlContent', $iyzico3DResponse['threeDSHtmlContent']);
                \DB::commit();

                return redirect()->route('payment.threeDSecurityRequest');
            }
            $this->paymentService->logPaymentError($payment, $order);
            error($payment['errorMessage']);

            return back()->withInput();
        } catch (\Exception $exception) {
            \DB::rollBack();
            error($exception->getMessage());

            return back()->withInput();
        }
    }

    /**
     * bankadan dönen 3D ödeme sayfası kullanıcıya gösterilir.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function threeDSecurityRequest(Request $request)
    {
        $orderId = session()->get('orderId');
        Log::addIyzicoLog('3D sayfasına gelindi', "sipariş id : {$orderId}", $orderId, Log::TYPE_ORDER);
        if (! $orderId) {
            Log::addIyzicoLog('Sipariş id olmadığı için 3d kapatıldı', 'order id :' . $orderId, $orderId, Log::TYPE_ORDER);

            return redirect()->route('odemeView')->withErrors(__('lang.no_order_found_to_pay'));
        }

        return view('site.payment.iyzico.threeDSecurity');
    }

    /**
     * iyzico 3D doğrulama sonrası post attığı istek.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function threeDSecurityResponse(Request $request)
    {
        $requestData = $request->only('status', 'paymentId', 'conversationId', 'mdStatus');
        $orderId = session()->get('orderId');
        Log::addIyzicoLog('iyzico 3D response geldi', (string) json_encode($requestData), $orderId, Log::TYPE_ORDER);
        $order = Order::find($orderId);

        if ('success' !== $requestData['status']) {
            Log::addIyzicoLog('iyzico 3D response success değil', (string) json_encode($requestData), $orderId, Log::TYPE_ORDER);

            return redirect()->route('odemeView')->withErrors(Iyzico::getMdStatusByParam($requestData['mdStatus']));
        }
        $isThreeDSCompletedResponse = $this->paymentService->completeIyzico3DSecurityPayment($requestData['conversationId'], $requestData['paymentId']);
        if (false === $isThreeDSCompletedResponse) {
            Log::addIyzicoLog('iyzico 3D response false döndü', null, $orderId, Log::TYPE_ORDER);

            return redirect()->route('odemeView')->withErrors(__('lang.an_error_occurred_during_the_process'));
        }
        if ('success' === mb_strtolower($isThreeDSCompletedResponse['status'])) {
            Log::addIyzicoLog('iyzico 3D response başarılı', json_encode($isThreeDSCompletedResponse), $orderId, Log::TYPE_ORDER);
            $this->completeOrderStatusChangeToTrue($order);
            $this->orderService->createOrderIyzicoDetail($isThreeDSCompletedResponse, $orderId);

            return redirect()->route('user.orders')->with('message', __('lang.the_order_has_been_received_successfully'));
        }
        $message = (array) $isThreeDSCompletedResponse['errorMessage'];
        İyzicoFailsJson::addLog(null, $order->full_name, $order->basket_id, json_encode($isThreeDSCompletedResponse, \JSON_UNESCAPED_UNICODE));

        return redirect()->route('odemeView')->withErrors($message);
    }

    /**
     * sipariş tamamlandığında stok düşürme kupon silme işlemlerini yapar.
     *
     * @param Order $order
     *
     * @return bool
     */
    public function completeOrderStatusChangeToTrue(Order $order)
    {
        $basket = $order->basket;
        $order->update(['is_payment' => 1, 'status' => Order::STATUS_ONAY_BEKLIYOR]);
        Log::addIyzicoLog('sipariş durumu tamamlandı olarak işaretlenecek', $basket ? $basket->toJson() : '', $basket->id);

        $this->dispatch(new NewOrderAddedJob($order));
        foreach ($this->cartItems() as $cartItem) {
            $this->checkProductVariantAndDecrementQty((int) $cartItem->attributes->product['id'], (int) $cartItem->quantity, $order->currency_id, $cartItem->attributes->sub_attribute_id_list);
            $this->removeCartItem($cartItem->id);
        }
        $this->couponService->decrementCouponQty($basket->coupon_id);
        $basket->basket_items()->update(['status' => BasketItem::STATUS_ONAY_BEKLIYOR]);
        session()->forget(['current_basket_id', 'orderId']);

        Log::addIyzicoLog('Sipariş is_payment tamamlandı eski basket silindi', null, $order->id, Log::TYPE_ORDER);

        return true;
    }
}
