<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\EBultenInterface;

class EBultenController extends Controller
{
    private EBultenInterface $bultenService;

    public function __construct(EBultenInterface $bultenService)
    {
        $this->bultenService = $bultenService;
    }

    public function list()
    {
        $list = $this->bultenService->allWithPagination();

        return view('admin.ebulten.listBultens', compact('list'));
    }

    public function delete($id)
    {
        $this->bultenService->delete($id);

        return redirect(route('admin.ebulten'));
    }
}
