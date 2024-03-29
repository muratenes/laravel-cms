<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\OurTeam;
use App\Repositories\Interfaces\OurTeamInterface;

class ElOurTeamDal extends BaseRepository implements OurTeamInterface
{
    public function __construct(OurTeam $model)
    {
        parent::__construct($model);
    }
}
