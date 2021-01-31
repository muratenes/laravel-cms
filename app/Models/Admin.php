<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $guarded = ['id'];
    protected $table = 'admin';

    protected $casts = [
        'modules_status' => 'array',
        'modules' => 'array',
        'dashboard' => 'array',
        'image_quality' => 'array',
    ];
}
