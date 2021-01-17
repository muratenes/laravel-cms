<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Repositories\Interfaces\BannerInterface;
use App\Http\Controllers\Controller;
use App\Repositories\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use ImageUploadTrait;

    protected BannerInterface $model;

    public function __construct(BannerInterface $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        $query = request('q');
        if ($query) {
            $list = $this->model->allWithPagination([['title', 'like', "%$query%"]]);
        } else {
            $list = $this->model->allWithPagination();
        }
        return view('admin.banner.listBanners', compact('list'));
    }

    public function newOrEditForm($id = 0)
    {
        $banner = new Banner();
        if ($id != 0) {
            $banner = $this->model->find($id);
        }
        return view('admin.banner.newOrEditBanner', compact('banner'));
    }

    public function save(Request $request, $id = 0)
    {
        $request_data = $request->only(['title', 'sub_title', 'link', 'lang', 'sub_title_2']);
        $request_data['active'] = activeStatus();
        if ($id != 0) {
            $entry = $this->model->update($request_data, $id);
        } else {
            $entry = $this->model->create($request_data);
        }
        if ($entry) {
            $imageName = $this->uploadImage($request->file('image'), $entry->title, 'public/banners', $entry->image, Banner::MODULE_NAME);
            $entry->update(['image' => $imageName]);
            return redirect(route('admin.banners.edit', $entry->id));
        }

        return back()->withInput();
    }

    public function delete($id)
    {
        $this->model->delete($id);
        success();

        return redirect(route('admin.banners'));
    }
}
