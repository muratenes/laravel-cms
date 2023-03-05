<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Repositories\Interfaces\CouponInterface;
use App\Repositories\Traits\CartTrait;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    use CartTrait;

    protected CouponInterface $model;

    public function __construct(CouponInterface $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function applyCoupon(Request $request)
    {
        $validated = $request->validate(['code' => 'string|required']);
        $productIdList = $this->getProductIdList();

        $basket = $request->user() ? Basket::getCurrentBasket() : null;
        $result = $this->model->checkCoupon($productIdList, $validated['code'], $this->getCardSubTotal(), currentCurrencyID(), $basket);

        return redirect(route('basket'))->with('message', $result['message'])->with('message_type', $result['alert']);
    }
}
