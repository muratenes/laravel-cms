<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Repositories\Interfaces\GalleryInterface;
use App\Repositories\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoGalleryController extends Controller
{
    use ImageUploadTrait;

    protected GalleryInterface $model;

    public function __construct(GalleryInterface $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        if (! config('admin.use_album_gallery')) {
            return redirect(route('admin.gallery.edit', 0));
        }
        $query = request('q');
        if ($query) {
            $list = $this->model->allWithPagination([['title', 'like', "%{$query}%"]]);
        } else {
            $list = $this->model->allWithPagination();
        }

        return view('admin.gallery.listGallery', compact('list'));
    }

    public function newOrEditForm($id = 0)
    {
        $images = [];
        $item = new Gallery();
        // multiple image gallery
        if (config('admin.use_album_gallery')) {
            if (0 != $id) {
                $item = $this->model->find($id);
            }
        } else {
            $firstItem = Gallery::first();
            $item = $firstItem ?: $item;
        }

        return view('admin.gallery.editGallery', compact('item', 'images'));
    }

    public function save(Request $request, $id = 0)
    {
        $request_data['title'] = $request->get('title');
        $request_data['slug'] = createSlugByModelAndTitle($this->model, $request_data['title'], $id);
        $request_data['active'] = activeStatus();
        if (0 != $id) {
            $entry = $this->model->update($request_data, $id);
        } else {
            $entry = $this->model->create($request_data);
        }

        $entry->update([
            'image' => $this->uploadImage($request->file('image'), $entry->title, 'public/gallery', $entry->image, Gallery::MODULE_NAME),
        ]);
        // todo : use multiple image upload trait
        if (request()->hasFile('imageGallery')) {
            foreach ($request->file('imageGallery') as $imageItem) {
                $uploadedPath = $this->uploadImage($imageItem, $request_data['title'], 'public/gallery/items', null, GalleryImage::MODULE_NAME);
                $entry->images()->create([
                    'image' => $uploadedPath,
                ]);
            }
        }
        success();

        return redirect(route('admin.gallery.edit', $entry->id));
    }

    public function delete($id)
    {
        $this->model->delete($id);

        return redirect(route('admin.gallery'));
    }

    public function deleteGalleryImage($id)
    {
        $item = GalleryImage::findOrFail($id);
        $imagePath = "public/gallery/items/{$item->image}";
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
        $item->delete();
        success();

        return back();
    }
}
