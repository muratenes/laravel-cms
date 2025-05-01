<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\OrderFilter;
use App\Http\Requests\Admin\OrderCreateRequest;
use App\Repositories\Traits\ResponseTrait;
use App\Repositories\Traits\SiparisUrunTrait;
use App\Services\Order\OrderCreateService;
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
        $filter_types = Order::listStatusWithId();
        $companies = $this->productCompanyService->all();
        $categories = $this->categoryService->all([['parent_category_id', null]], ['id', 'title', 'parent_category_id'], ['sub_categories']);
        $states = $this->cityTownService->all();

        return view('admin.order.list_orders', compact('filter_types', 'companies', 'categories', 'states'));
    }

    public function createOrder(OrderCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->createService->create($request->getOrderCreateDto());
        return response()->json();
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
            Order::with(
                ['basket' => function ($query) {
                    $query->withTrashed();
                }, 'delivery_address' => function ($query) {
                    $query->select(['id', 'title', 'state_id', 'district_id'])->with(['state', 'district'])->withTrashed();
                }, 'basket.user:id,name,surname,email']
            )->filter($filter)
        )->make(true);
    }
}
