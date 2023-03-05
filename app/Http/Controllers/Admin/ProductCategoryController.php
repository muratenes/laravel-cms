<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminCategoryRequest;
use App\Models\Kategori;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Traits\ImageUploadTrait;
use App\Repositories\Traits\ResponseTrait;
use App\Utils\Concerns\Models\MultiLanguageHelper;

// todo : Ürün kategori için polyformic kategoriyi kullan
class ProductCategoryController extends AdminController
{
    use ImageUploadTrait;
    use MultiLanguageHelper;
    use ResponseTrait;

    protected CategoryInterface $model;

    public function __construct(CategoryInterface $model)
    {
        $this->model = $model;
    }

    public function listCategories()
    {
        $query = request('q');
        $main_cat = request('parent_category');
        if ($query || $main_cat) {
            $list = $this->model->getCategoriesByHasCategoryAndFilterText($main_cat, $query, true);
        } else {
            $list = $this->model->allWithPagination(null, ['*'], null, ['parent_category']);
        }
        $main_categories = $this->model->all([['parent_category_id', null]]);

        return view('admin.product.category.list_categories', compact('list', 'main_categories'));
    }

    public function newOrEditCategory($category_id = 0)
    {
        $category = new Kategori();
        $categories = Kategori::all();
        if (0 !== $category_id) {
            $category = Kategori::with('languages')->findOrFail($category_id);
        }

        return view('admin.product.category.new_edit_category', compact('category', 'categories'));
    }

    public function saveCategory(AdminCategoryRequest $request, $category_id = 0)
    {
        $request_data = $request->only('title', 'parent_category_id', 'icon', 'spot', 'row');
        $request_data['active'] = activeStatus();
        $request_data['slug'] = createSlugByModelAndTitle($this->model, $request->title, $category_id);
        if ($request_data['parent_category_id']) {
            $parentCategory = Kategori::find($request_data['parent_category_id']);
            $parentSlug = createSlugByModelAndTitle($this->model, $parentCategory->title, $request_data['parent_category_id']);
            $request_data['slug'] = createSlugByModelAndTitle($this->model, $parentSlug . '-' . $request_data['slug'], $category_id);
        }
        if (0 !== $category_id) {
            $entry = $this->model->update($request_data, $category_id);
        } else {
            $entry = $this->model->create($request_data);
        }

        if ($entry) {
            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request->file('image'), $entry->title, 'public/categories', $entry->image, Kategori::MODULE_NAME);
                $entry->update(['image' => $imagePath]);
            }
            $this->syncModelForOtherLanguages($request, $entry);

            return redirect(route('admin.product.category.edit', $entry->id));
        }

        return back()->withInput();
    }

    public function deleteCategory($category_id)
    {
        Kategori::findOrFail($category_id)->delete();
        success();

        return redirect(route('admin.product.categories'));
    }

    /**
     * @param int $categoryID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubCategoriesByID(int $categoryID)
    {
        return $this->success([
            'categories' => $this->model->getSubCategoriesByCategoryId($categoryID),
        ]);
    }
}
