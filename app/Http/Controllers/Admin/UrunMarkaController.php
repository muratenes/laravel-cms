<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product\UrunFirma;
use App\Models\Product\UrunMarka;
use App\Repositories\Interfaces\UrunMarkaInterface;
use App\Http\Controllers\Controller;
use App\Repositories\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class UrunMarkaController extends Controller
{
    use ImageUploadTrait;

    protected UrunMarkaInterface $model;

    public function __construct(UrunMarkaInterface $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        $query = \request()->get('q', null);
        $list = $this->model->allWithPagination([['title', 'like', "%$query%"]]);
        return view('admin.product.brands.listProductBrands', compact('list'));
    }

    public function detail($id = 0)
    {
        $item = $id != 0 ? $this->model->find($id) : new UrunMarka();

        return view('admin.product.brands.newOrEditProductBrand', compact('item'));
    }

    public function save(Request $request, $id = 0)
    {
        $request_data = $request->only('title');
        $request_data['active'] = activeStatus();
        $request_data['slug'] = createSlugByModelAndTitle($this->model, $request_data['title'], $id);
        if ($id != 0) {
            $entry = $this->model->update($request_data, $id);
        } else {
            $entry = $this->model->create($request_data);
        }

        if ($entry) {
            if (request()->hasFile('image')) {
                $this->uploadImage($request->file('image'), $request_data['title'], 'public/company', $entry->image, UrunFirma::MODULE_NAME);
            }
            success();
            return redirect(route('admin.product.brands.edit', $entry->id));
        }
        UrunMarka::clearCache();

        return back()->withInput();
    }

    public function delete($id)
    {
        $this->model->delete($id);
        UrunMarka::clearCache();
        return redirect(route('admin.product.brands.list'));
    }

}
