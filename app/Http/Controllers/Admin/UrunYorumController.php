<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product\UrunAttribute;
use App\Models\Product\UrunYorum;
use App\Repositories\Interfaces\UrunYorumInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UrunYorumController extends Controller
{
    protected UrunYorumInterface $model;

    public function __construct(UrunYorumInterface $model)
    {
        $this->model = $model;
    }

    public function list(Request $request)
    {
        $list = UrunYorum::when($request->get('productID'), function ($q, $v) {
            $q->where('product_id', $v);
        })->latest()->paginate();

        return view('admin.product.comments.listProductComments', compact('list'));
    }

    public function detail($id = 0)
    {
        if ($id != 0)
            $item = $this->model->getById($id, null, ['product', 'user']);
        else
            $item = new UrunAttribute();
        if ($id != 0 and !$item->is_read) {
            $item->update(['is_read' => 1]);
        }
        return view('admin.product.comments.editOrNewComment', compact('item'));
    }

    public function save($id = 0)
    {
        $request_data = \request()->only('title');
        $request_data['active'] = request()->has('active') ? 1 : 0;
        if ($id != 0) {
           $this->model->update($request_data, $id);
        } else {
            $this->model->create($request_data);
        }
        return redirect(route('admin.product.comments.list'));
    }

    public function delete($category_id)
    {
        $this->model->delete($category_id);
        return redirect(route('admin.product.comments.list'));
    }
}
