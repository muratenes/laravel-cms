<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Repositories\Interfaces\BlogInterface;
use App\Repositories\Traits\ResponseTrait;
use App\Utils\Concerns\Admin\MultipleImageConcern;
use Illuminate\Http\Request;
use MuratEnes\LaravelMetaTags\Traits\MetaTaggable;

class BlogController extends Controller
{
    use MultipleImageConcern;
    use ResponseTrait;

    protected BlogInterface $model;

    public function __construct(BlogInterface $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return view('admin.blog.index');
    }

    public function create()
    {
        return view('admin.blog.create', [
            'item'                => new Blog(),
            'categories'          => Category::where(['categorizable_type' => Blog::class])->get(),
            'selected_categories' => [],
            'subCategories'       => [],
        ]);
    }

    public function edit(Blog $blog)
    {
        $this->authorizeForUser(loggedAdminUser(), 'view', $blog);

        return view('admin.blog.create', [
            'item'                => $blog,
            'categories'          => Category::where(['categorizable_type' => Blog::class])->get(),
            'selected_categories' => $blog->categories->pluck('id')->toArray(),
            'subCategories'       => Category::where(['categorizable_type' => Blog::class, 'parent_category_id' => $blog->category_id])->get()->toArray(),
        ]);
    }

    public function update(Request $request, Blog $blog)
    {
        $requestData = $request->validate([
            'title'           => 'required|string|max:200',
            'tags'            => 'nullable|max:255',
            'description'     => 'nullable|max:65535',
            'lang'            => 'nullable|numeric',
            'category_id'     => 'nullable|numeric',
            'sub_category_id' => 'nullable|numeric',
        ]);
        $metaValidated = $request->validate(MetaTaggable::validation_rules());

        $requestData += [
            'is_active' => activeStatus('is_active'),
            'image'     => $this->uploadImage($request->file('image'), $blog->title, 'public/blog', $blog->image, Blog::MODULE_NAME),
        ];

        $blog->update($requestData);
        $blog->meta_tag()->updateOrCreate(['taggable_id' => $blog->id], $metaValidated);
        $this->uploadMultipleImages($request, $blog, 'public/blog/gallery');

        success();

        return redirect(route('admin.blog.edit', $blog->id));
    }

    public function store(Request $request, $id = 0)
    {
        $requestData = $request->validate([
            'title'           => 'required|string|max:200',
            'tags'            => 'nullable|max:255',
            'description'     => 'nullable|max:65535',
            'lang'            => 'nullable|numeric',
            'category_id'     => 'nullable|numeric',
            'sub_category_id' => 'nullable|numeric',
        ]);
        $metaValidated = $request->validate(MetaTaggable::validation_rules());

        $requestData += [
            'is_active' => activeStatus('is_active'),
            'image'     => $this->uploadImage($request->file('image'), $requestData['title'], 'public/blog', null, Blog::MODULE_NAME),
            'writer_id' => loggedAdminUser()->id,
        ];

        $blog = Blog::create($requestData);
        $blog->meta_tag()->updateOrCreate(['taggable_id' => $blog->id], $metaValidated);

        success();

        return redirect(route('admin.blog.edit', $blog->id));
    }

    public function delete($id)
    {
        $this->model->delete($id);

        return $this->success();
    }
}
