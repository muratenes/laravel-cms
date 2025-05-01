<?php

namespace App\Http\Controllers\Admin;

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

}
