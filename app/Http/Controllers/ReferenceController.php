<?php

namespace App\Http\Controllers;

use App\Models\Reference;
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

        return view('site.reference.listReferences', compact('list'));
    }

    public function detail(Reference $reference)
    {
        return view('site.reference.referenceDetail', compact('reference'));
    }
}
