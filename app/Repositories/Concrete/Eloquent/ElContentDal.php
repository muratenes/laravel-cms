<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Content;
use App\Repositories\Interfaces\ContentInterface;

class ElContentDal extends BaseRepository implements ContentInterface
{
    public function __construct(Content $model)
    {
        parent::__construct($model);
    }

    public function delete($id): bool
    {
        $item = $this->find($id);
        if ($item->image) {
            $path = "public/contents/{$item->image}";
            if (\Storage::exists($path)) {
                \Storage::delete($path);
            }
        }

        return (bool) $item->delete();
    }
}
