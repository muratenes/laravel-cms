<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\HttpException;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\AdminProductSaveRequest;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorProduct;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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

    public function newProduct()
    {
        $product = new Product();

        return view("admin.product.new_edit_product", compact('product'));
    }

    public function editProduct(Product $product)
    {
        $vendors = Vendor::where('is_active', 1)->orderBy('title')->get()->toArray();
        $customPrices = VendorProduct::where(['product_id' => $product->id])->get();
        return view("admin.product.new_edit_product", compact('product', 'vendors', 'customPrices'));
    }

    public function saveCustomPrices(Request $request, Product $product): \Illuminate\Http\RedirectResponse
    {
        $rows = [];
        foreach ($request->get('vendor_id') as $index => $vendorId) {
            $rows[] = [
                'vendor_id' => $vendorId,
                'price' => $request->get('price')[$index],
            ];
            if ((float)$request->get('price')[$index] < $product->purchase_price) {
                throw new HttpException("Özel fiyat ürünün alış fiyatından küçük olamaz");
            }
        }

        foreach ($rows as $row) {
            VendorProduct::updateOrCreate(
                ['product_id' => $product->id, 'vendor_id' => $row['vendor_id']],
                ['price' => $row['price'], 'product_id' => $product->id]
            );
        }

        success();
        return back();
    }

    public function saveProduct(AdminProductSaveRequest $request, $product_id = 0)
    {
        $validated = $request->validated();
        if (!empty($product_id)) {
            $product = Product::find($product_id);
            $product->fill($validated);
            $product->save();
            success("Ürün güncellendi");
            return back();
        }

        $product = new Product();
        $product->fill($validated);
        $product->save();
        success("Ürün eklendi");
        return redirect()->route('admin.product.edit', ['product' => $product->id]);
    }

    /**
     * @param ProductFilter $filter
     *
     * @return mixed
     * @throws \Exception
     *
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
