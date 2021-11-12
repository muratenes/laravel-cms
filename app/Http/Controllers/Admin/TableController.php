<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Content;
use App\Models\Product\UrunFirma;
use App\User;
use Illuminate\Http\Request;
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

    /**
     * @throws \Exception
     *
     * @return mixed
     */
    public function categories(Request $request)
    {
        return Datatables::of(
            Category::with(['parent_category'])->when($request->get('type'), function ($query) use ($request) {
                $query->where('categorizable_type', $request->get('type'));
            })
        )->make();
    }

    /**
     * @throws \Exception
     *
     * @return mixed
     */
    public function contents(Request $request)
    {
        return Datatables::of(
            Content::query()
        )->make();
    }

    /**
     * @throws \Exception
     *
     * @return mixed
     */
    public function banners(Request $request)
    {
        return Datatables::of(
            Banner::query()
        )->make();
    }
}
