<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Repositories\Interfaces\BlogInterface;
use App\Http\Controllers\Controller;
use App\Repositories\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use ImageUploadTrait;

    protected BlogInterface $model;

    public function __construct(BlogInterface $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        $query = request('q');
        if ($query) {
            $list = $this->model->allWithPagination([['title', 'like', "%$query%"]]);
        } else {
            $list = $this->model->allWithPagination();
        }
        return view('admin.blog.listBlogs', compact('list'));
    }

    public function newOrEditForm($id = 0)
    {
        $item = new Blog();
        $selected_categories = [];
        if ($id != 0) {
            $item = $this->model->find($id);
            $selected_categories = $item->categories()->pluck('category_id')->all();
        }
        $categories = BlogCategory::all();
        return view('admin.blog.newOrEditBlog', compact('item','categories','selected_categories'));
    }

    public function save(Request $request, $id = 0)
    {
        $request_data = $request->only('title', 'desc', 'lang', 'tags');
        $request_data['active'] = activeStatus();
        $request_data['slug'] = createSlugByModelAndTitle($this->model, $request->title, $id);
        if ($id != 0) {
            $entry = $this->model->update($request_data, $id);
        } else {
            $entry = $this->model->create($request_data);
        }
        if ($entry) {
            $filePath = $this->uploadImage($request->file('image'), $entry->title, 'public/blog', $entry->image, Blog::MODULE_NAME);
            $entry->update(['image' => $filePath]);
            success();
            return redirect(route('admin.blog.edit', $entry->id));
        } else
            return back()->withInput();
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect(route('admin.blog'));
    }
}
