<?php

namespace App\Services;

use App\Services\Product\ProductService;
use App\Services\Vendor\VendorService;

class DashboardService
{
    public function init(): array
    {
        return [
            'vendors' => VendorService::vendors(),
            'products' => ProductService::products(),
        ];
    }
}