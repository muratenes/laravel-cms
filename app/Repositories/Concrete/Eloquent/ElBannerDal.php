<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Banner;
use App\Repositories\Interfaces\BannerInterface;

class ElBannerDal extends BaseRepository implements BannerInterface
{
    public function __construct(Banner $model)
    {
        parent::__construct($model);
    }

    public function delete($id): bool
    {
        $item = $this->find($id);
        if ($item->image) {
            $path = "public/banners/{$item->image}";
            if (\Storage::exists($path)) {
                \Storage::delete($path);
            }
        }

        return (bool) $item->delete();
    }
}
