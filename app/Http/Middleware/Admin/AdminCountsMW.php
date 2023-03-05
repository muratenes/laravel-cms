<?php

namespace App\Http\Middleware\Admin;

use App\Models\Order;
use Illuminate\Support\Facades\View;

class AdminCountsMW
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $counts = [
            'order' => Order::where(['status' => Order::STATUS_ONAY_BEKLIYOR])->count(),
        ];
        View::share('counts', $counts);

        return $next($request);
    }
}
