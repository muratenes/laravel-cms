<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Builder\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Menu::orderBy('order')->with(['children', 'parent'])->whereNull('parent_id')->paginate(100);

        return view('admin.builder.menus.list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.builder.menus.create',[
            'items' => Menu::orderBy('title')->get()->toArray(),
            'modules' => Menu::MODULES,
            'item' => new Menu()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['status'] = activeStatus('status');
        $item = Menu::create($data);
        success();

        return redirect(route('admin.builder.menus.edit', $item->id));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Menu $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $item)
    {
        $items = Menu::orderBy('title')->get()->toArray();
        $modules = Menu::MODULES;
        return view('admin.builder.menus.create', compact('item', 'items', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Menu $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Menu $item)
    {
        $data = $request->all();
        $data['status'] = activeStatus('status');
        $item->update($data);
        success();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
