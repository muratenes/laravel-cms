<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
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
        $contacts = Contact::query();

        return Datatables::of($contacts)->make();
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

        return redirect(route('admin.contact'))->with('message_success', 'işlem başarılı');
    }
}
