<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContentManagementRequest;
use App\Models\Content;
use App\Repositories\Interfaces\IcerikYonetimInterface;
use App\Repositories\Traits\ImageUploadTrait;
use App\Repositories\Traits\ResponseTrait;
use App\Utils\Concerns\Admin\MultipleImageConcern;
use MuratEnes\LaravelMetaTags\Traits\MetaTaggable;

class ContentController extends AdminController
{
    use ImageUploadTrait;
    use MultipleImageConcern;
    use ResponseTrait;

    protected IcerikYonetimInterface $model;

    public function __construct(IcerikYonetimInterface $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return view('admin.content.index');
    }

    /**
     * @param Content $content
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Content $content)
    {
        $item = new Content();
        $contents = $this->model->all();
        if ($content->id) {
            $item = $this->model->find($content->id);
        }

        return view('admin.content.edit', compact('item', 'contents'));
    }

    /**
     * create or update content.
     *
     * @param ContentManagementRequest $request
     * @param int                      $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(ContentManagementRequest $request, $id = 0)
    {
        $validated = $request->validated();
        $metaValidated = $request->validate(MetaTaggable::validation_rules());
        $validated += [
            'active'    => activeStatus(),
            'show_menu' => activeStatus('show_menu'),
            'slug'      => createSlugByModelAndTitle($this->model, $validated['title'], $id),
        ];
        if ($id) {
            $entry = $this->model->update($validated, $id);
        } else {
            $entry = $this->model->create($validated);
        }
        if ($entry) {
            $entry->update([
                'image' => $this->uploadImage($request->file('image'), $entry->title, 'public/contents', $entry->image, Content::MODULE_NAME),
            ]);
            success();
            $entry->meta_tag()->updateOrCreate(['taggable_id' => $entry->id], $metaValidated);
            $this->uploadMultipleImages($request, $entry, 'public/contents/gallery');

            return redirect(route('admin.content.edit', $entry->id));
        }

        return back()->withInput();
    }

    public function delete(Content $content)
    {
        $this->model->delete($content->id);
        \Cache::forget('contents');

        return $this->success();
    }
}
