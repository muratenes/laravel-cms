<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use App\Repositories\Interfaces\FotoGalleryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class FotoGalleryController extends Controller
{
    protected FotoGalleryInterface $model;

    public function __construct(FotoGalleryInterface $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        if (!config('admin.use_album_gallery')) {
            return redirect(route('admin.gallery.edit', 0));
        }
        $query = request('q');
        if ($query) {
            $list = $this->model->allWithPagination([['title', 'like', "%$query%"]]);
        } else {
            $list = $this->model->allWithPagination();
        }
        return view('admin.gallery.listGallery', compact('list'));
    }

    public function newOrEditForm($id = 0)
    {
        $images = [];
        $item = new Gallery();
        if (!config('admin.use_album_gallery')) {
            $galleries = $this->model->all();
            if (count($galleries) > 0) {
                $item = $this->model->getById($galleries[count($galleries) - 1])[0];
                $images = $item->images;
            }
        } else {
            if ($id != 0) {
                $item = $this->model->getById($id);
                if ($item)
                    $images = $item->images;
            }
        }
        return view('admin.gallery.editGallery', compact('item', 'images'));
    }

    public function save($id = 0)
    {
        $request_data = \request()->only('title');
        $request_data['slug'] =  Str::slug(request('title'));
        $i = 0;
        while ($this->model->all([['slug', $request_data['slug']], ['id', '!=', $id]], ['id'])->count() > 0) {
            $request_data['slug'] = $request_data['slug'] . '-' . $i;
            $i++;
        }
        $request_data['active'] = request()->has('active') ? 1 : 0;
        if ($id != 0) {
            $entry = $this->model->update($request_data, $id);
        } else {
            $entry = $this->model->create($request_data);
        }
        if ($entry) {
            if (request()->hasFile('image') && $entry) {
                $this->validate(request(), [
                    'image' => 'image|mimes:jpg,png,jpeg,gif|max:' . config('admin.max_upload_size')
                ]);
                $this->model->uploadMainImage($entry, request()->file('image'));
            }
            if (request()->hasFile('imageGallery')) {
                $this->validate(request(), [
                    'imageGallery.*' => 'image|mimes:jpg,png,jpeg,gif|max:' . config('admin.max_upload_size')
                ]);
                $this->model->uploadImageGallery($entry->id, request()->file('imageGallery'), $entry);
            }
            return redirect(route('admin.gallery.edit', $entry->id));
        }
        return back()->withInput();
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect(route('admin.gallery'));
    }

    public function deleteGalleryImage($id)
    {
        $response = $this->model->deleteGalleryImage($id);
        return back()->with('message_type', $response['alert'])->with('message', $response['message']);
    }
}
