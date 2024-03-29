<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Log;
use App\Repositories\Interfaces\LogInterface;

class ElLogDal extends BaseRepository implements LogInterface
{
    public function __construct(Log $model)
    {
        parent::__construct($model);
    }

    public function getLogsByUserId($userId)
    {
        return Log::where('user_id', $userId)->orderByDesc('id')->get();
    }
}
