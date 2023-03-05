<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\OrderInterface;

class IyzicoController extends Controller
{
    protected OrderInterface $model;

    public function __construct(OrderInterface $model)
    {
        $this->model = $model;
    }

    public function iyzicoErrorOrderList()
    {
        $query = request('q');
        $list = $this->model->getIyzicoErrorLogs($query);

        return view('admin.order.listIyzicoFails', compact('list'));
    }

    public function iyzicoErrorOrderDetail($id)
    {
        $json = $this->model->getOrderIyzicoDetail($id)->json_response;

        return json_decode($json, true);
    }
}
