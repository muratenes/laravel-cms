<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use App\Models\Siparis;
use App\Models\Product\Urun;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AnasayfaController extends Controller
{
    public function index()
    {
        $best_sellers = DB::select('select u.title,SUM(su.qty) as qty
            from siparisler as  si
            inner join  sepet as s on si.sepet_id = s.id
            inner join  sepet_urun as su on s.id = su.sepet_id
            inner join urunler as u on su.product_id = u.id
            group by u.title
            order by SUM(su.qty) DESC limit 8');
        $orders_count_per_month = DB::select('select DATE_FORMAT(si.created_at,\'%Y-%m\') as ay, sum(su.qty) qty
            from siparisler as si
            inner join sepet s on si.sepet_id = s.id
            inner join sepet_urun su on s.id = su.sepet_id
            group by DATE_FORMAT(si.created_at,\'%Y-%m\')
            order by DATE_FORMAT(si.created_at,\'%Y-%m\') limit 8');
        $data = Cache::remember('adminIndexData', 2, function () {
            return [
                'pending_orders_count' => Siparis::getOrderCountByStatus(Siparis::STATUS_SIPARIS_ALINDI),
                'completed_orders_count' => Siparis::getOrderCountByStatus(Siparis::STATUS_TAMAMLANDI),
                'total_order_count' => Siparis::count(),
                'total_user_count' => User::count(),
                'last_orders' => Siparis::with('basket.user')->orderByDesc('id')->take(6)->get(),
                'product_list' => Urun::with('categories')->orderByDesc('id')->take(6)->get(),
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

