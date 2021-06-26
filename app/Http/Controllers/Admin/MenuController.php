<?php

namespace App\Http\Controllers\Admin;

use App\Models\Builder\Menu;
use App\Models\Builder\MenuDescription;
use Illuminate\Http\Request;

class MenuController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Menu::orderBy('order')->with(['children', 'parent', 'descriptions'])->whereNull('parent_id')->paginate(100);

        return view('admin.builder.menus.list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.builder.menus.create', [
            'items'   => Menu::orderBy('title')->get()->toArray(),
            'modules' => Menu::MODULES,
            'item'    => new Menu(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
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
     *
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
     * @param Menu                     $item
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Menu $item)
    {
        $data = $request->only(['title', 'href', 'order', 'parent_id', 'module']);
        $data['status'] = activeStatus('status');
        $item->update($data);
        $this->syncLanguages($request, $item);
        success();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Menu $item
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $item)
    {
        $item->delete();
        success();

        return back();
    }

    /**
     * @param Request $request
     * @param Menu    $item
     */
    private function syncLanguages(Request $request, Menu $item)
    {
        foreach ($this->otherActiveLanguages() as $language) {
            if ($request->has('title_' . $language[0])) {
                $titleLang = $request->get("title_{$language[0]}");
                $hrefLang = $request->get("href_{$language[0]}");
                MenuDescription::updateOrCreate(
                    ['lang' => $language[0], 'menu_id' => $item->id],
                    ['title' => $titleLang, 'href' => $hrefLang]
                );
            } else {
                MenuDescription::create([
                    'lang'    => $language[0],
                    'menu_id' => $item->id,
                ]);
            }
        }
    }
}
