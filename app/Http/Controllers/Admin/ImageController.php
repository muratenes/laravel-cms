<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    use ResponseTrait;

    /**
     * delete any image by id from database and storage.
     *
     * @param Request $request
     * @param Image   $image
     *
     * @return array
     */
    public function delete(Request $request, Image $image)
    {
        $validated = $request->validate([
            'path' => 'required|string|max:140|starts_with:public|ends_with:/',
        ]);
        $imagePath = "{$validated['path']}{$image->title}";
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
        $image->delete();

        return $this->response();
    }
}
