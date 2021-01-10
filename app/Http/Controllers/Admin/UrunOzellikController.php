<?php

namespace App\Http\Controllers\Admin;


use App\Models\Product\UrunAttribute;
use App\Models\Product\UrunSubAttribute;
use App\Repositories\Interfaces\UrunlerInterface;
use App\Repositories\Interfaces\UrunOzellikInterface;
use App\Repositories\Traits\ResponseTrait;
use App\Utils\Concerns\Admin\ProductAttributeConcern;
use Illuminate\Http\Request;

class UrunOzellikController extends AdminController
{
    use ProductAttributeConcern;
    use ResponseTrait;

    protected UrunOzellikInterface $model;
    protected UrunlerInterface $productService;

    public function __construct(UrunOzellikInterface $model,UrunlerInterface $productService)
    {
        $this->model = $model;
        $this->productService = $productService;
    }

    public function list()
    {
        $query = \request()->get('q', null);
        $list = $this->model->allWithPagination([['title', 'like', "%$query%"]]);
        return view('admin.product.attributes.listAttributes', compact('list'));
    }

    public function detail($id = 0)
    {
        $item = $id != 0 ? $this->model->getById($id, null, 'subAttributes.descriptions') : new UrunAttribute();
        return view('admin.product.attributes.editOrNewAttribute', compact('item'));
    }

    public function save(Request $request, UrunAttribute $attribute)
    {
        $attribute->title = $request->get('title_' . defaultLangID());
        $attribute->active = activeStatus();
        $attribute->save();
        $this->syncProductAttributeOtherLanguages($request, $attribute);
        $this->syncProductSubAttributeOtherLanguages($request, $attribute);
        return redirect(route('admin.product.attribute.edit', $attribute->id))->with('message', 'işlem başarılı');
    }

    public function create(Request $request)
    {
        $requestData = [
            'title' => $request->get('title_' . defaultLangID()),
            'active' => activeStatus()
        ];
        $attribute = UrunAttribute::create($requestData);
        if ($attribute) {
            $this->syncProductAttributeOtherLanguages($request, $attribute);
            $this->syncProductSubAttributeOtherLanguages($request, $attribute);
        }
        return redirect(route('admin.product.attribute.edit', $attribute->id))->with('message', 'işlem başarılı');
    }

    public function deleteSubAttribute($id)
    {
        try {
            $subAttribute = UrunSubAttribute::find($id);
            $subAttribute->delete();
            UrunSubAttribute::clearCache();
            return response()->json('true');
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }

    }

    public function delete($category_id)
    {
        $this->model->delete($category_id);
        UrunAttribute::clearCache();
        return redirect(route('admin.product.attribute.list'));
    }

    // AJAX

    public function addNewProductSubAttribute()
    {
        $index = \request()->get('index');
        return view('admin.product.attributes.partials.add-new-sub-attribute-ajax', compact('index'));
    }

    public function getSubAttributesByAttributeId($id)
    {
        return  $this->success([
            'sub_attributes' => UrunSubAttribute::where('parent_attribute', $id)->orderBy('title')->get(),
        ]);
    }

    public function getAllProductAttributes()
    {
        return  $this->success([
            'attributes' => UrunAttribute::where('active', 1)->orderBy('title')->get(),
        ]);
    }

}
