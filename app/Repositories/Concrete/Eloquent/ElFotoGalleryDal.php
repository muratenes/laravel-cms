<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Gallery;
use App\Repositories\Interfaces\FotoGalleryInterface;
use Illuminate\Support\Facades\Storage;

class ElFotoGalleryDal extends BaseRepository implements FotoGalleryInterface
{
    public function __construct(Gallery $model)
    {
        parent::__construct($model);
    }

    public function delete($id): bool
    {
        $item = $this->find($id);
        if ($item->image) {
            $image_path = "photo-gallery/{$item->image}";
            if (Storage::exists($image_path)) {
                \Storage::delete($image_path);
            }
        }

        return (bool) $item->delete();
    }
}
