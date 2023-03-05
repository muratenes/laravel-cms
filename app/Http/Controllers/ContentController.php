<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Repositories\Interfaces\IcerikYonetimInterface;

class ContentController extends Controller
{
    private IcerikYonetimInterface $_icerikYonetimService;

    public function __construct(IcerikYonetimInterface $icerikYonetimService)
    {
        $this->_icerikYonetimService = $icerikYonetimService;
    }

    public function detail(Content $content)
    {
        return view('site.content.contentDetail', compact('content'));
    }
}
