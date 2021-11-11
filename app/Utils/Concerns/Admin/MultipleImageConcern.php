<?php

namespace App\Utils\Concerns\Admin;

use App\Repositories\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

trait MultipleImageConcern
{
    use ImageUploadTrait;

    /**
     * @param Request $request
     * @param $model
     * @param string $folderPath ex: public/categories/gallery
     *
     * @return null|void
     */
    public function uploadMultipleImages(Request $request, $model, string $folderPath)
    {
        if (! $request->hasFile('images')) {
            return null;
        }
        foreach ($request->file('images') as $image) {
            $model->images()->create([
                'title' => $this->uploadImage($image, $model->title, $folderPath, null),
            ]);
        }
    }
}
