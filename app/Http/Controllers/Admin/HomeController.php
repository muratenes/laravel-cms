<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $data = Cache::remember('adminIndexData', 2, function () {
            return [
                'pending_orders_count'   => 0,
                'completed_orders_count' => 0,
                'total_order_count'      => 0,
                'total_user_count'       => 0,
                'last_orders'            => 0,
                'product_list'           => [],
            ];
        });
        $data['best_sellers'] = null;
        $data['sellers_per_month'] = null;

        return view('admin.index', compact('data'));
    }

}
