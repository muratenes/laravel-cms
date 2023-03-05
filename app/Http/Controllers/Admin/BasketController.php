<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasketItem;
use App\Repositories\Traits\ResponseTrait;

class BasketController extends Controller
{
    use ResponseTrait;

    /**
     * @param int $basketID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $basketID)
    {
        return $this->success([
            'basket' => BasketItem::withTrashed()->find($basketID)->append(['total', 'sub_total']),
        ]);
    }
}
