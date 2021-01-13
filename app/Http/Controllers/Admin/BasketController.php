<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SepetUrun;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    use ResponseTrait;

    /**
     * @param int $basketID
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $basketID)
    {
        return $this->success([
            'basket' => SepetUrun::withTrashed()->find($basketID)->append(['total', 'sub_total'])
        ]);
    }
}
