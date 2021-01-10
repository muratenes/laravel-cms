<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\KuponInterface;
use App\Repositories\Interfaces\SiparisInterface;
use Illuminate\Http\Request;

class IyzicoController extends Controller
{
    protected SiparisInterface $model;

    public function __construct(SiparisInterface $model)
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
        return json_decode($json,true);
    }
}
