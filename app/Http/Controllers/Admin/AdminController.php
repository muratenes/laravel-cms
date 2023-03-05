<?php

namespace App\Http\Controllers\Admin;

use App\Models\Config;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ResponseTrait;
    use ValidatesRequests;

    /**
     * get all active languages.
     *
     * @return array
     */
    public function languages()
    {
        return Config::activeLanguages();
    }

    /**
     * get all active languages without default language.
     *
     * @return \Illuminate\Support\Collection
     */
    public function otherActiveLanguages()
    {
        return Config::otherActiveLanguages();
    }

    /**
     * get all active currencies.
     *
     * @return array[]
     */
    public function activeCurrencies()
    {
        return Config::activeCurrencies();
    }

    /**
     * get all currencies.
     *
     * @return array[]
     */
    public function currencies()
    {
        return Config::currencies();
    }
}
