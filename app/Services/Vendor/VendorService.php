<?php

namespace App\Services\Vendor;

use App\Models\Vendor;

class VendorService
{

    public static function vendors(): \Illuminate\Database\Eloquent\Collection
    {
        return Vendor::orderBy('title')->get();
    }
}