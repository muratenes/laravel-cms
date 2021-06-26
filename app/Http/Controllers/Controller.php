<?php

namespace App\Http\Controllers;

use App\Repositories\Traits\CartTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use CartTrait;
    use DispatchesJobs;
    use ValidatesRequests;
}
