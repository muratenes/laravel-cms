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
use App\Repositories\Interfaces\CouponInterface;
use App\Repositories\Interfaces\OrderInterface;
use App\Repositories\Interfaces\PaymentInterface;
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

    private OrderInterface $orderService;
    private PaymentInterface $paymentService;
    private CityTownInterface $cityTownService;
    private AccountInterface $accountService;
    private CouponInterface $couponService;



    public function index(Request $request)
    {

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

    }
}
