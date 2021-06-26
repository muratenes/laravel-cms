<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurTeam extends Model
{
    public const MODULE_NAME = 'our_team';

    public const IMAGE_QUALITY = 90;
    public const IMAGE_RESIZE = null;
    public $timestamps = false;
    public $guarded = [];

    protected $perPage = 20;
    protected $table = 'takimimiz';
}
