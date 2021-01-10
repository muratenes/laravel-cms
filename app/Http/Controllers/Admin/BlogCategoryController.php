<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{


    public function list()
    {
        $search = request('q');
        $list = BlogCategory::when($search, function ($query) use ($search) {
            $query->where('title', "ILIKE", "%$search%");
        })->simplePaginate();
        $main_categories = BlogCategory::whereNull('parent_category')->get();
        return view('admin.blog.category.list_categories', compact('list', 'main_categories'));
    }

    public function newOrEdit($category_id = 0)
    {
        $categories = BlogCategory::all();
        $category = new BlogCategory();
        if ($category_id != 0) {
            $category = BlogCategory::findOrFail($category_id);
        }
        return view('admin.blog.category.new_edit_category', compact('category', 'categories'));
    }

    public function save(Request $request, $category_id = 0)
    {
        $request->validate([
            'title' => 'required|max:255',
            'parent_cateogory' => 'integer',
        ]);
        $request_data = $request->only('title', 'parent_category', 'icon', 'spot', 'row');
        $request_data['active'] = activeStatus();
        $request_data['slug'] = $this->createSlugByModelAndTitle(BlogCategory::class, $request->title, $category_id);
        if ($category_id != 0) {
            $entry = BlogCategory::findOrFail($category_id);
            $entry->update($request_data);
        } else {
            $entry = BlogCategory::create($request_data);
        }
        if ($entry)
            return redirect(route('admin.blog_category.edit', $entry->id));
        return back()->withInput();
    }

    public function delete(BlogCategory $BlogCategory)
    {
        $BlogCategory->delete();
        return redirect(route('admin.blog_category'));
    }

    private function createSlugByModelAndTitle($model, $title, $itemID)
    {
        $i = 0;
        $slug = Str::slug($title);
        while (BlogCategory::where([['slug', $slug], ['id', '!=', $itemID]], ['id'])->count() > 0) {
            $slug = Str::slug(request('title')) . '-' . $i;
            $i++;
        }
        return $slug;
    }
}
