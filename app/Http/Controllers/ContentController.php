<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Repositories\Interfaces\ContentInterface;

class ContentController extends Controller
{
    private ContentInterface $_icerikYonetimService;

    public function __construct(ContentInterface $icerikYonetimService)
    {
        $this->_icerikYonetimService = $icerikYonetimService;
    }

    public function detail(Content $content)
    {
        return view('site.content.contentDetail', compact('content'));
    }
}
