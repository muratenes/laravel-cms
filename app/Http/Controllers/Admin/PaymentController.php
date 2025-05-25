<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\OrderFilter;
use App\Http\Filters\PaymentFilter;
use App\Http\Requests\Admin\OrderCreateRequest;
use App\Http\Requests\Admin\PaymentCreateRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Repositories\Traits\ResponseTrait;
use App\Repositories\Traits\SiparisUrunTrait;
use App\Services\Order\OrderCreateService;
use App\Services\Payment\PaymentCreateService;
use App\Services\Vendor\VendorService;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    use ResponseTrait;
    use SiparisUrunTrait;

    public function __construct(private readonly PaymentCreateService $createService)
    {
    }


    public function list()
    {
        return view('admin.payment.list_payments');
    }

    public function createPayment(PaymentCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->createService->create($request->getCreateDto());
        return response()->json($result);
    }

    public function ajax(PaymentFilter $filter)
    {
        return DataTables::of(
            Payment::with(['vendor:id,title','user:id,name'])->filter($filter)
        )->make(true);
    }
}
