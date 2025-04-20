<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\Interfaces\CampaignInterface;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponseTrait;

    protected ProductInterface $model;
    private CampaignInterface $_campaignService;

    public function __construct(ProductInterface $model)
    {
        $this->model = $model;
    }

    public function detail(Product $product)
    {
        return view('site.product.product', compact('product'));
    }
}
