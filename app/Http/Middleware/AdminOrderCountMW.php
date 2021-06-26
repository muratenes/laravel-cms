<?php

namespace App\Http\Middleware;

use App\Models\SepetUrun;
use App\Models\Siparis;
use Closure;
use Illuminate\Support\Facades\View;

class AdminOrderCountMW
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $pendingOrderCount = Siparis::where('status', Siparis::STATUS_ONAY_BEKLIYOR)->count();
        $pendingRefundRequestCount = Siparis::whereHas('basket.basket_items', function ($q) {
            $q->where('status', SepetUrun::STATUS_IADE_TALEP);
        })->count();
        View::share('pendingOrderCount', $pendingOrderCount);
        View::share('pendingRefundRequestCount', $pendingRefundRequestCount);

        return $next($request);
    }
}
