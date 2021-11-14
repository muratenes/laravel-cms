<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use MuratEnes\LaravelMetaTags\Traits\MetaTaggable;

class CategoryController extends AdminController
{
    public function index()
    {
        return view('admin.category.index');
    }

    public function create()
    {
        return view('admin.category.create', [
            'item'       => new Category(),
            'categories' => Category::orderBy('title')->get(),
        ]);
    }

    public function show(Category $category)
    {
        return view('admin.category.create', [
            'item'       => $category,
            'categories' => Category::orderBy('title')->where(['categorizable_type' => $category->categorizable_type])->get(),
        ]);
    }

    /**
     * @param Request  $request
     * @param Category $category
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'title'              => 'required|max:100',
            'parent_category_id' => 'nullable',
            'categorizable_type' => 'required|string|max:100',
        ]);
        $metaValidated = $request->validate(MetaTaggable::validation_rules());

        $validated['is_active'] = activeStatus('is_active');
        $category->update($validated);
        $category->meta_tag()->updateOrCreate(['taggable_id' => $category->id], $metaValidated);

        success();

        return back();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'              => 'required|max:100',
            'parent_category_id' => 'nullable|numeric',
            'categorizable_type' => 'required|string|max:100',
        ]);
        $validated['is_active'] = activeStatus('is_active');
        $metaValidated = $request->validate(MetaTaggable::validation_rules());

        $category = Category::create($validated);
        $category->meta_tag()->updateOrCreate(['taggable_id' => $category->id], $metaValidated);

        success();

        return redirect(route('admin.categories.edit', ['category' => $category->id]));
    }

    /**
     * @param Category $category
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Category $category)
    {
        $category->delete();

        return $this->success();
    }

    /**
     * get sub categories by category.
     *
     * @param Category $category
     *
     * @return mixed
     */
    public function subCategories(Category $category)
    {
        return Category::where(['parent_category_id' => $category->id])->orderBy('title')->get();
    }

    /**
     * @param string $type
     *
     * @return mixed
     */
    public function categoriesByType(Request $request)
    {
        return Category::where(['categorizable_type' => $request->get('type')])
            ->orderBy('title')->get();
    }
}
