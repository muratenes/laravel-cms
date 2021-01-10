<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\ProductFilter;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    public function list()
    {
        return view('admin.contact.list_contact');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function ajax()
    {
        $contacts = Contact::query();

        return Datatables::of($contacts)->make();
    }

    /**
     * @param Contact $contact
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function delete(Contact $contact)
    {
        $contact->delete();
        return redirect(route('admin.contact'))->with('message_success', 'işlem başarılı');
    }
}
