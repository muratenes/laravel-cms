<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Repositories\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class AdvertController extends Controller
{
    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $list = Advert::latest()->paginate();

        return view('admin.advert.list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.advert.create', [
            'item'  => new Advert(),
            'types' => Advert::listStatusWithId(),
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
        $validated = $this->validateRequest($request);
        $validated['status'] = activeStatus('status');
        $advert = Advert::create($validated);
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), $advert->title, 'public/wads', $advert->image, Advert::MODULE_NAME);
            $advert->update(['image' => $imagePath]);
        }
        success();

        return redirect(route('admin.adverts.edit', $advert->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Advert $advert
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Advert $advert)
    {
        return view('admin.advert.create', [
            'item'  => $advert,
            'types' => Advert::listStatusWithId(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Advert                   $advert
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Advert $advert)
    {
        $validated = $this->validateRequest($request);
        $validated['status'] = activeStatus('status');
        $advert->update($validated);
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), $advert->title, 'public/wads', $advert->image, Advert::MODULE_NAME);
            $advert->update(['image' => $imagePath]);
        }
        success();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Advert $advert
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Advert $advert)
    {
        $advert->delete();
        success();

        return back();
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'title'             => 'required|max:255',
            'sub_title'         => 'nullable|string|max:255',
            'redirect_to'       => 'nullable|string|max:255',
            'redirect_to_label' => 'nullable|string|max:100',
            'type'              => 'required|string|max:100',
            'lang'              => 'required|numeric',
        ]);
    }
}
