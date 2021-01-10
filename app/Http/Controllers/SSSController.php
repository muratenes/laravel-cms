<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\SSSInterface;
use Illuminate\Http\Request;

class SSSController extends Controller
{
    private SSSInterface $_sssService;

    public function __construct(SSSInterface $ssService)
    {
        $this->_sssService = $ssService;
    }

    public function list()
    {
        $list = $this->_sssService->allWithPagination();
        return view('site.sss.listSSS', compact('list'));
    }
}
