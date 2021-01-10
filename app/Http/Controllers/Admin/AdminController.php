<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ayar;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * aktif dilleri dönderir
     * @return \Illuminate\Support\Collection
     */
    public function languages()
    {
        return Ayar::activeLanguages();
    }

    /**
     * sitenin ana dili hariç aktif dilleri dönderir
     * @return \Illuminate\Support\Collection
     */
    public function otherActiveLanguages()
    {
       return Ayar::otherActiveLanguages();
    }


    /**
     * sitede bulunan aktif para birimleri
     * @return array[]
     */
    public function activeCurrencies()
    {
        return Ayar::activeCurrencies();
    }
}
