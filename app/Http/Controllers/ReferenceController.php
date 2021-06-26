<?php

namespace App\Http\Controllers;

use App\Models\Referance;
use App\Repositories\Interfaces\ReferenceInterface;

class ReferenceController extends Controller
{
    private ReferenceInterface $_referenceService;

    public function __construct(ReferenceInterface $referenceService)
    {
        $this->_referenceService = $referenceService;
    }

    public function list()
    {
        $list = $this->_referenceService->allWithPagination();

        return view('site.referans.listReferences', compact('list'));
    }

    public function detail(Referance $reference)
    {
        return view('site.referans.referenceDetail', compact('reference'));
    }
}
