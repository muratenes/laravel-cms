<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Product\Product;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $best_sellers = DB::select('select u.title,SUM(su.qty) as qty
            from orders as  si
            inner join  baskets as s on si.basket_id = s.id
            inner join  basket_product as su on s.id = su.basket_id
            inner join products as u on su.product_id = u.id
            group by u.title
            order by SUM(su.qty) DESC limit 8');
        $orders_count_per_month = DB::select('select DATE_FORMAT(si.created_at,\'%Y-%m\') as ay, sum(su.qty) qty
            from orders as si
            inner join baskets s on si.basket_id = s.id
            inner join basket_product su on s.id = su.basket_id
            group by DATE_FORMAT(si.created_at,\'%Y-%m\')
            order by DATE_FORMAT(si.created_at,\'%Y-%m\') limit 8');
        $data = Cache::remember('adminIndexData', 2, function () {
            return [
                'pending_orders_count'   => Order::getOrderCountByStatus(Order::STATUS_SIPARIS_ALINDI),
                'completed_orders_count' => Order::getOrderCountByStatus(Order::STATUS_TAMAMLANDI),
                'total_order_count'      => Order::count(),
                'total_user_count'       => User::count(),
                'last_orders'            => Order::with('basket.user')->orderByDesc('id')->take(6)->get(),
                'product_list'           => Product::with('categories')->orderByDesc('id')->take(6)->get(),
            ];
        });
        $data['best_sellers'] = $best_sellers;
        $data['sellers_per_month'] = $orders_count_per_month;

        return view('admin.index', compact('data'));
    }

    public function contacts()
    {
        return json_decode(Contact::orderByDesc('id')->get());
    }

    public function cacheClear()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('view:cache');
        Artisan::call('config:cache');
        Cache::forget('adminIndexData');
        Cache::flush();
        session()->flash('message', 'önbellek temizlendi');

        return redirect('/admin/home');
    }
}
