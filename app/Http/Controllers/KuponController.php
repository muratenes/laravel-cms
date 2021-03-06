<?php

namespace App\Http\Controllers;

use App\Models\Sepet;
use App\Repositories\Interfaces\KuponInterface;
use App\Repositories\Traits\CartTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KuponController extends Controller
{
    use CartTrait;

    protected KuponInterface $model;

    public function __construct(KuponInterface $model)
    {
        $this->model = $model;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function applyCoupon(Request $request)
    {
        $validated = $request->validate(['code' => 'string|required']);
        $productIdList = $this->getProductIdList();

        $basket = $request->user() ? Sepet::getCurrentBasket() : null;
        $result = $this->model->checkCoupon($productIdList, $validated['code'], $this->getCardSubTotal(), currentCurrencyID(), $basket);

        return redirect(route('basket'))->with('message', $result['message'])->with('message_type', $result['alert']);
    }
}
