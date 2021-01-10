<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurTeam extends Model
{
    const MODULE_NAME = 'our_team';

    protected $perPage = 20;
    protected $table = "takimimiz";
    public $timestamps = false;
    public $guarded = [];

    const  IMAGE_QUALITY = 90;
    const  IMAGE_RESIZE = null;
}
