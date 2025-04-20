<?php

namespace App\Http\Controllers\Admin;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\AdminProductSaveRequest;
use App\Models\Product;
use App\Repositories\Traits\ResponseTrait;
use Yajra\DataTables\DataTables;

class ProductController extends AdminController
{
    use ResponseTrait;



    public function getAllProductsForSearchAjax()
    {
        $query = request()->get('text');
//        $data = $this->model->getProductsBySearchTextForAjax($query);

        return response()->json([]);
    }

    public function listProducts()
    {
        $products = Product::all();

        return view('admin.product.list_products', compact('products'));
    }

    public function newOrEditProduct($product_id = 0)
    {
        $product = new Product();
    }

    public function saveProduct(AdminProductSaveRequest $request, $product_id = 0)
    {

    }

    /**
     * @param ProductFilter $filter
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function ajax(ProductFilter $filter)
    {
        return DataTables::of(
            Product::with(['vendors:id,title'])
        )->make(true);
    }

    public function deleteProduct(Product $product)
    {


        return redirect(route('admin.products'));
    }
}
