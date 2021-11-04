<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        return view('admin.category.index');
    }

    public function subCategories(Category $category)
    {
        return Category::where(['parent_category_id' => $category->id])->orderBy('title')->get();
    }

    public function create()
    {
        return view('admin.category.edit', [
            'item'       => new Category(),
            'categories' => Category::orderBy('title')->get(),
        ]);
    }

    public function show(Category $category)
    {
        return view('admin.category.edit', [
            'item'       => $category,
            'categories' => Category::orderBy('title')->get(),
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
            'parent_category_id' => 'nullable|numeric|exists:categories',
            'categorizable_type' => 'required|string|max:100',
        ]);
        $validated['is_active'] = activeStatus('is_active');
        $category->update($validated);

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
            'parent_category_id' => 'nullable|numeric|exists:categories',
            'categorizable_type' => 'required|string|max:100',
        ]);
        $validated['is_active'] = activeStatus('is_active');
        $category = Category::create($validated);

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
}
