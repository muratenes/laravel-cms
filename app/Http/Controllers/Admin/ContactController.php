<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends AdminController
{
    public function list()
    {
        return view('admin.contact.list_contact');
    }

    /**
     * @throws \Exception
     *
     * @return mixed
     */
    public function ajax()
    {
        return Datatables::of(
            Contact::query()
        )->make();
    }

    /**
     * @param Contact $contact
     *
     * @throws \Exception
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Contact $contact)
    {
        $contact->delete();
        success();

        return redirect(route('admin.contact'));
    }
}
