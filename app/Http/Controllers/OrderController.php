<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\Interfaces\KuponInterface;
use App\Repositories\Interfaces\SiparisInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected SiparisInterface $model;

    public function __construct(SiparisInterface $model, KuponInterface $couponService)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $orders = $this->model->getUserAllOrders($request->user()->id);

        return view('site.order.orders', compact('orders'));
    }

    /**
     * @param Order $order
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Order $order)
    {
        return view('site.order.order-detail', compact('order'));
    }
}
