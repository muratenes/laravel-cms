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
        $admin = Admin::first();
        foreach ($data['modules_status'] as $index => $status) {
            $data['modules_status'][$index] = (bool)$status;
        }
        foreach ($data['modules'] as $index => $status) {
            foreach ($data['modules'][$index] as $subIndex => $value) {
                if ($value == "on" || $value == 0) {
                    $data['modules'][$index][$subIndex] = (boolean)$value;
                } else {
                    $data['modules'][$index][$subIndex] = $value;
                }
            }
            $data['modules_status'][$index] = (bool)$status;
        }
        $admin->update($data);
        success();

        return back();
    }
}
