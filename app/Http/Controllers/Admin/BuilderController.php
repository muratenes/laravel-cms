<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class BuilderController extends AdminController
{
    public function edit()
    {
        return view('admin.builder.edit', [
            'item' => Admin::first(),
            'currencies' => $this->currencies()
        ]);
    }

    public function save(Request $request)
    {
        $data = $request->all();
//        dd($data);
        $admin = Admin::first();
        $admin->update($data);
        success();

        return back();
    }
}
