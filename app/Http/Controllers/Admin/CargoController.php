<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\Region\Country;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $list = Cargo::latest('id')->paginate();

        return view('admin.config.cargo.list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $cargo = new Cargo();
        $countries = Country::select('id', 'title')->orderBy('title')->get();

        return view('admin.config.cargo.edit', compact('cargo', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'max:255',
            'cargo_tracking_url' => 'max:255|nullable',
            'cargo_free_amount' => 'nullable|min:0',
            'country_id' => 'required',
        ]);
        $cargo = Cargo::create($validated);
        success();

        return redirect(route('admin.cargo.show', $cargo->id));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Cargo $cargo
     * @return \Illuminate\Http\Response
     */
    public function show(Cargo $cargo)
    {
        $countries = Country::select('id', 'title')->orderBy('title')->get();

        return view('admin.config.cargo.edit', compact('cargo', 'countries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Cargo $cargo
     * @return \Illuminate\Http\Response
     */
    public function edit(Cargo $cargo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cargo $cargo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Cargo $cargo)
    {
        $validated = $request->validate([
            'title' => 'max:255',
            'cargo_tracking_url' => 'max:255|nullable',
            'cargo_free_amount' => 'nullable|min:0',
            'country_id' => 'required',
        ]);

        $cargo->update($validated);
        success();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Cargo $cargo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Cargo $cargo)
    {
        $cargo->delete();
        success();
        return redirect(route('admin.cargo.index'));
    }
}
