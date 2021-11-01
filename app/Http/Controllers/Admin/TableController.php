<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Product\UrunFirma;
use App\User;
use Yajra\DataTables\Facades\DataTables;

class TableController extends Controller
{
    /**
     * admin contact page list.
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function contact()
    {
        $contacts = Contact::query();

        return Datatables::of($contacts)->make();
    }

    /**
     * admin blog page list.
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function blog()
    {
        return Datatables::of(
            Blog::query()
        )->make();
    }

    /**
     * @throws \Exception
     *
     * @return mixed
     */
    public function companies()
    {
        return Datatables::of(
            UrunFirma::with(['user', 'package'])
        )->make();
    }

    /**
     * @throws \Exception
     *
     * @return mixed
     */
    public function users()
    {
        return Datatables::of(
            User::with('role')
        )->make();
    }
}
