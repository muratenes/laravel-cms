<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\OrderFilter;
use App\Http\Filters\PaymentFilter;
use App\Http\Requests\Admin\OrderCreateRequest;
use App\Models\Order;
use App\Repositories\Traits\ResponseTrait;
use App\Repositories\Traits\SiparisUrunTrait;
use App\Services\Order\OrderCreateService;
use App\Services\Vendor\VendorService;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    use ResponseTrait;
    use SiparisUrunTrait;

    public function __construct(private readonly OrderCreateService $createService)
    {
    }


    public function list()
    {
        return view('admin.payment.list_payments');
    }

    public function createPayment(OrderCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->createService->create($request->getOrderCreateDto());
        return response()->json($result);
    }

    public function ajax(PaymentFilter $filter)
    {
        return DataTables::of(
            Order::with(['vendor:id,title','user:id,name','transactions.product'])->filter($filter)
        )->make(true);
    }
}
