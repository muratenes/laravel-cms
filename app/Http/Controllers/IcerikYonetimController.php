<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Repositories\Interfaces\IcerikYonetimInterface;

class IcerikYonetimController extends Controller
{
    private IcerikYonetimInterface $_icerikYonetimService;

    public function __construct(IcerikYonetimInterface $icerikYonetimService)
    {
        $this->_icerikYonetimService = $icerikYonetimService;
    }

    public function detail(Content $content)
    {
        return view('site.icerik.contentDetail', compact('content'));
    }
}
