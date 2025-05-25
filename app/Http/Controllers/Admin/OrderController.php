<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\OrderFilter;
use App\Http\Requests\Admin\OrderCreateRequest;
use App\Models\Order;
use App\Models\Vendor;
use App\Repositories\Traits\ResponseTrait;
use App\Repositories\Traits\SiparisUrunTrait;
use App\Services\Order\OrderCreateService;
use App\Services\Vendor\VendorService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    use ResponseTrait;
    use SiparisUrunTrait;

    public function __construct(private readonly OrderCreateService $createService)
    {
    }


    public function list()
    {
        $vendors = VendorService::vendors();

        return view('admin.order.list_orders', compact('vendors'));
    }

    public function createOrder(OrderCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->createService->create($request->getOrderCreateDto());
        return response()->json($result);
    }

    /**
     * @param OrderFilter $filter
     *
     * @return mixed
     * @throws \Exception
     *
     */
    public function ajax(OrderFilter $filter)
    {
        return DataTables::of(
            Order::with(['vendor','user'])->filter($filter)
        )->make(true);
    }
}
