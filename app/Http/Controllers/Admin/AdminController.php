<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ayar;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * aktif dilleri dönderir.
     *
     * @return \Illuminate\Support\Collection
     */
    public function languages()
    {
        return Ayar::activeLanguages();
    }

    /**
     * sitenin ana dili hariç aktif dilleri dönderir.
     *
     * @return \Illuminate\Support\Collection
     */
    public function otherActiveLanguages()
    {
        return Ayar::otherActiveLanguages();
    }

    /**
     * sitede bulunan aktif para birimleri.
     *
     * @return array[]
     */
    public function activeCurrencies()
    {
        return Ayar::activeCurrencies();
    }

    /**
     * sitede bulunan aktif para birimleri.
     *
     * @return array[]
     */
    public function currencies()
    {
        return Ayar::currencies();
    }
}
