<?php

namespace App\Http\Controllers;

use App\Models\Siparis;
use App\Repositories\Concrete\BaseRepository;
use App\Repositories\Interfaces\KuponInterface;
use App\Repositories\Interfaces\SiparisInterface;
use Illuminate\Http\Request;

class SiparisController extends Controller
{
    protected SiparisInterface $model;
    private KuponInterface $_kuponService;

    public function __construct(SiparisInterface $model, KuponInterface $kuponService)
    {
        $this->model = $model;
        $this->_kuponService = $kuponService;
    }

    public function index(Request $request)
    {
        $orders = $this->model->getUserAllOrders($request->user()->id);
        return view('site.siparis.siparisler', compact('orders'));
    }

    /**
     * @param Siparis $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Siparis $order)
    {
        return view('site.siparis.siparisDetay', compact('order'));
    }
}
