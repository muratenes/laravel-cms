<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Repositories\Interfaces\BlogInterface;
use App\Repositories\Traits\ImageUploadTrait;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;
use MuratEnes\LaravelMetaTags\Traits\MetaTaggable;

class BlogController extends Controller
{
    use ImageUploadTrait;
    use ResponseTrait;

    protected BlogInterface $model;

    public function __construct(BlogInterface $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $query = request('q');
        if ($query) {
            $list = $this->model->allWithPagination([['title', 'like', "%{$query}%"]]);
        } else {
            $list = $this->model->allWithPagination();
        }

        return view('admin.blog.listBlogs', compact('list'));
    }

    public function create()
    {
        return view('admin.blog.newOrEditBlog', [
            'item'                => new Blog(),
            'categories'          => Category::where(['categorizable_type' => Blog::class])->get(),
            'selected_categories' => [],
            'subCategories'       => [],
        ]);
    }

    public function edit(Blog $blog)
    {
        return view('admin.blog.newOrEditBlog', [
            'item'                => $blog,
            'categories'          => Category::where(['categorizable_type' => Blog::class])->get(),
            'selected_categories' => $blog->categories->pluck('id')->toArray(),
            'sub_categories'      => Category::where(['categorizable_type' => Blog::class, 'parent_category_id' => $blog->id])->get(),
        ]);
    }

    public function save(Request $request, $id = 0)
    {
        $request_data = $request->only('title', 'desc', 'lang', 'tags');
        $metaValidated = $request->validate(MetaTaggable::validation_rules());

        $request_data['active'] = activeStatus();
        $request_data['slug'] = createSlugByModelAndTitle($this->model, $request->title, $id);
        if (0 !== $id) {
            $entry = $this->model->update($request_data, $id);
            $entry->meta_tag()->updateOrCreate(['taggable_id' => $id], $metaValidated);
        } else {
            $entry = $this->model->create($request_data);
        }
        if ($entry) {
            $filePath = $this->uploadImage($request->file('image'), $entry->title, 'public/blog', $entry->image, Blog::MODULE_NAME);
            $entry->update(['image' => $filePath]);
            $entry->categories()->sync($request->get('categories'));
            success();

            return redirect(route('admin.blog.edit', $entry->id));
        }

        return back()->withInput();
    }

    public function delete($id)
    {
        $this->model->delete($id);

        return $this->success();
    }
}
