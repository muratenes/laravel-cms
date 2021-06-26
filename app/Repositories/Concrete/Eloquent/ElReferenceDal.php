<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Referance;
use App\Repositories\Interfaces\ReferenceInterface;

class ElReferenceDal extends BaseRepository implements ReferenceInterface
{
    protected $model;

    public function __construct(Referance $model)
    {
        parent::__construct($model);
    }

    public function delete($id): bool
    {
        $item = $this->find($id);
        if ($item->image) {
            $path = "public/references/{$item->image}";
            if (\Storage::exists($path)) {
                \Storage::delete($path);
            }
        }

        return (bool) $item->delete();
    }
}
