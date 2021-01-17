<?php namespace App\Repositories\Concrete\Eloquent;

use App\Models\Content;
use App\Models\SSS;
use App\Repositories\Concrete\ElBaseRepository;
use App\Repositories\Interfaces\IcerikYonetimInterface;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ElIcerikYonetimDal extends BaseRepository implements IcerikYonetimInterface
{
    protected $model;

    public function __construct(Content $model)
    {
        parent::__construct($model);
    }

    public function delete($id) : bool
    {
        $item = $this->find($id);
        if ($item->image) {
            $path = "public/contents/$item->image";
            if (\Storage::exists($path)) {
                \Storage::delete($path);
            }
        }
        return (bool) $item->delete();
    }
}
