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

    /**
     * @throws \Exception
     *
     * @return mixed
     */
    public function blogs()
    {
        return Datatables::of(
            Blog::with(['writer:name,surname,email,id', 'categories:id,title'])
                ->when(! loggedAdminUser()->isSuperAdmin(), function ($query) {
                    $query->where('writer_id', loggedAdminUser()->id);
                })
        )->make();
    }
}
