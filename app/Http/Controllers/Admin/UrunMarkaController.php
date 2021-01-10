<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product\UrunAttribute;
use App\Models\Product\UrunMarka;
use App\Repositories\Interfaces\UrunMarkaInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class UrunMarkaController extends Controller
{
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
        if ($id != 0)
            $item = $this->model->getById($id, null);
        else
            $item = new UrunMarka();
        return view('admin.product.brands.newOrEditProductBrand', compact('item'));
    }

    public function save($id = 0)
    {
        $request_data = \request()->only('title');
        $request_data['active'] = request()->has('active') ? 1 : 0;
        $request_data['slug'] =  Str::slug(request('title'));
        if ($this->model->all([['slug', $request_data['slug']], ['id', '!=', $id]], ['id'])->count() > 0) {
            return back()->withInput()->withErrors('slug alanı zaten kayıtlı');
        }
        if ($id != 0) {
            $entry = $this->model->update($request_data, $id);
        } else {
            $entry = $this->model->create($request_data);
        }
        if (request()->hasFile('image') && $entry) {
            $this->validate(request(), [
                'image' => 'image|mimes:jpg,png,jpeg,gif|'.config('admin.max_upload_size')
            ]);
            $this->model->uploadBrandMainImage($entry, request()->file('image'));
        }
        UrunMarka::clearCache();
        if ($entry)
            return redirect(route('admin.product.brands.edit', $entry->id));
        return back()->withInput();
    }

    public function delete($id)
    {
        $this->model->delete($id);
        UrunMarka::clearCache();
        return redirect(route('admin.product.brands.list'));
    }

}
