<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Repositories\Interfaces\BannerInterface;
use App\Repositories\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class BannerController extends AdminController
{
    use ImageUploadTrait;

    protected BannerInterface $model;

    public function __construct(BannerInterface $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        return view('admin.banner.index');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banner.create', compact('banner'));
    }

    public function save(Request $request, $id)
    {
        $validated = $request->validate([
            'title'       => 'nullable|max:100|string',
            'sub_title'   => 'nullable|max:255|string',
            'sub_title_2' => 'nullable|max:255|string',
            'link'        => 'nullable|max:255|string',
            'lang'        => 'nullable|numeric',
        ]);
        $validated['active'] = activeStatus();
        if ($id) {
            $entry = $this->model->update($validated, $id);
        } else {
            $entry = $this->model->create($validated);
        }
        if ($entry) {
            $imageName = $this->uploadImage($request->file('image'), $entry->title, 'public/banners', $entry->image, Banner::MODULE_NAME);
            $entry->update(['image' => $imageName]);
            success();

            return redirect(route('admin.banners.edit', $entry->id));
        }

        return back()->withInput();
    }

    public function delete(Banner $banner)
    {
        $this->model->delete($banner->id);

        return $this->success();
    }
}
