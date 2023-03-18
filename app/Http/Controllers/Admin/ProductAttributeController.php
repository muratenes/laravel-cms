<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product\ProductAttribute;
use App\Models\Product\ProductSubAttribute;
use App\Repositories\Interfaces\ProductAttributeInterface;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Traits\ResponseTrait;
use App\Utils\Concerns\Admin\ProductAttributeConcern;
use App\Utils\Concerns\Models\MultiLanguageHelper;
use Illuminate\Http\Request;

class ProductAttributeController extends AdminController
{
    use MultiLanguageHelper;
    use ProductAttributeConcern;
    use ResponseTrait;

    protected ProductAttributeInterface $model;
    protected ProductInterface $productService;

    public function __construct(ProductAttributeInterface $model, ProductInterface $productService)
    {
        $this->model = $model;
        $this->productService = $productService;
    }

    public function list()
    {
        $query = request()->get('q', null);
        $list = $this->model->allWithPagination([['title', 'like', "%{$query}%"]]);

        return view('admin.product.attributes.listAttributes', compact('list'));
    }

    public function detail($id = 0)
    {
        $item = 0 != $id ? $this->model->getById($id, null, 'subAttributes.languages') : new ProductAttribute();

        return view('admin.product.attributes.editOrNewAttribute', compact('item'));
    }

    public function save(Request $request, ProductAttribute $attribute)
    {
        $attribute->title = $request->get('title');
        $attribute->active = activeStatus();
        $attribute->save();
        $this->syncModelForOtherLanguages($request, $attribute);
        $this->syncProductSubAttributeOtherLanguages($request, $attribute);

        return redirect(route('admin.product.attribute.edit', $attribute->id))->with('message', 'işlem başarılı');
    }

    public function create(Request $request)
    {
        $requestData = [
            'title'  => $request->get('title'),
            'active' => activeStatus(),
        ];
        $attribute = ProductAttribute::create($requestData);
        if ($attribute) {
            $this->syncModelForOtherLanguages($request, $attribute);
            $this->syncProductSubAttributeOtherLanguages($request, $attribute);
        }

        return redirect(route('admin.product.attribute.edit', $attribute->id))->with('message', 'işlem başarılı');
    }

    public function deleteSubAttribute($id)
    {
        try {
            $subAttribute = ProductSubAttribute::find($id);
            $subAttribute->delete();
            ProductSubAttribute::clearCache();

            return response()->json('true');
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function delete($category_id)
    {
        $this->model->delete($category_id);
        ProductAttribute::clearCache();

        return redirect(route('admin.product.attribute.list'));
    }

    // AJAX

    public function addNewProductSubAttribute()
    {
        $index = request()->get('index');

        return view('admin.product.attributes.partials.add-new-sub-attribute-ajax', compact('index'));
    }

    public function getSubAttributesByAttributeId($id)
    {
        return $this->success([
            'sub_attributes' => ProductSubAttribute::where('parent_attribute', $id)->orderBy('title')->get(),
        ]);
    }

    public function getAllProductAttributes()
    {
        return $this->success([
            'attributes' => ProductAttribute::where('active', 1)->orderBy('title')->get(),
        ]);
    }
}
