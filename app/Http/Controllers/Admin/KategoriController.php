<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminCategoryRequest;
use App\Models\Kategori;
use App\Models\Product\KategoriDescription;
use App\Repositories\Interfaces\KategoriInterface;
use App\Repositories\Traits\ImageUploadTrait;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;

class KategoriController extends AdminController
{
    use ResponseTrait;
    use ImageUploadTrait;

    protected KategoriInterface $model;

    public function __construct(KategoriInterface $model)
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
            $list = $this->model->allWithPagination(null, ["*"], null, ['parent_category']);
        }
        $main_categories = $this->model->all([['parent_category_id', null]]);

        return view('admin.category.list_categories', compact('list', 'main_categories'));
    }

    public function newOrEditCategory($category_id = 0)
    {
        $category = new Kategori();
        $categories = Kategori::all();
        if ($category_id != 0) {
            $category = Kategori::with('descriptions')->findOrFail($category_id);
        }

        return view('admin.category.new_edit_category', compact('category', 'categories'));
    }

    public function saveCategory(AdminCategoryRequest $request, $category_id = 0)
    {
        $request_data = $request->only('title', 'parent_category_id', 'icon', 'spot', 'row');
        $request_data['active'] = activeStatus();
        $request_data['slug'] = createSlugByModelAndTitle($this->model, $request->title, $category_id);
        if ($category_id != 0) {
            $entry = $this->model->update($request_data, $category_id);
        } else {
            $entry = $this->model->create($request_data);
        }

        if ($entry) {
            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request->file('image'), $entry->title, "public/categories", $entry->image, Kategori::MODULE_NAME);
                $entry->update(['image' => $imagePath]);
            }
            $this->syncCategoriesForOtherLanguages($request, $entry);
            return redirect(route('admin.category.edit', $entry->id));
        }
        return back()->withInput();
    }

    /**
     *  kategori diğer diller için descriptionları oluşuturur
     * @param Request $request
     * @param Kategori $category
     */
    private function syncCategoriesForOtherLanguages(Request $request, Kategori $category)
    {
        foreach ($this->otherActiveLanguages() as $language) {
            if ($request->has("title_" . $language[0])) {
                $categoryTitleByLanguage = $request->get("title_$language[0]");
                $categorySpotByLanguage = $request->get("spot_$language[0]");
                KategoriDescription::updateOrCreate(
                    ['lang' => $language[0], 'category_id' => $category->id],
                    ['title' => $categoryTitleByLanguage, 'spot' => $categorySpotByLanguage]
                );
            } else {
                KategoriDescription::create([
                    'lang' => $language[0],
                    'category_id' => $category->id
                ]);
            }
        }
    }

    public function deleteCategory($category_id)
    {
        $this->model->delete($category_id);
        success();
        return redirect(route('admin.categories'));
    }

    /**
     * @param int $categoryID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubCategoriesByID(int $categoryID)
    {
        return $this->success([
            'categories' => $this->model->getSubCategoriesByCategoryId($categoryID)
        ]);
    }
}
