<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductBrand;
use App\Models\Product\ProductCompany;
use App\Repositories\Interfaces\UrunMarkaInterface;
use App\Repositories\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class ProductBrandController extends Controller
{
    use ImageUploadTrait;

    protected UrunMarkaInterface $model;

    public function __construct(UrunMarkaInterface $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        $query = request()->get('q', null);
        $list = $this->model->allWithPagination([['title', 'like', "%{$query}%"]]);

        return view('admin.product.brands.listProductBrands', compact('list'));
    }

    public function detail($id = 0)
    {
        $item = 0 !== $id ? $this->model->find($id) : new ProductBrand();

        return view('admin.product.brands.newOrEditProductBrand', compact('item'));
    }

    public function save(Request $request, $id = 0)
    {
        $request_data = $request->only('title');
        $request_data['active'] = activeStatus();
        $request_data['slug'] = createSlugByModelAndTitle($this->model, $request_data['title'], $id);
        if (0 !== $id) {
            $entry = $this->model->update($request_data, $id);
        } else {
            $entry = $this->model->create($request_data);
        }

        if ($entry) {
            if (request()->hasFile('image')) {
                $this->uploadImage($request->file('image'), $request_data['title'], 'public/company', $entry->image, ProductCompany::MODULE_NAME);
            }
            success();

            return redirect(route('admin.product.brands.edit', $entry->id));
        }
        ProductBrand::clearCache();

        return back()->withInput();
    }

    public function delete($id)
    {
        $this->model->delete($id);
        ProductBrand::clearCache();

        return redirect(route('admin.product.brands.list'));
    }
}
