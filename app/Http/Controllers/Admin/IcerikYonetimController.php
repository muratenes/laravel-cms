<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContentManagementRequest;
use App\Models\Content;
use App\Repositories\Interfaces\IcerikYonetimInterface;
use App\Repositories\Traits\ImageUploadTrait;
use App\Repositories\Traits\ResponseTrait;

class IcerikYonetimController extends AdminController
{
    use ImageUploadTrait;
    use ResponseTrait;

    protected IcerikYonetimInterface $model;

    public function __construct(IcerikYonetimInterface $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return view('admin.content.listContents');
    }

    public function newOrEditForm(Content $content)
    {
        $item = new Content();
        $contents = $this->model->all();
        if ($content->id) {
            $item = $this->model->find($content->id);
        }

        return view('admin.content.newOrEditContent', compact('item', 'contents'));
    }

    public function save(ContentManagementRequest $request, Content $content)
    {
        $request_data = $request->validate([
            'parent_id' => 'nullable|numeric',
            'title'     => 'required|string|max:100',
            'lang'      => 'nullable|numeric',
            'spot'      => 'nullable|string|max:255',
        ]);
        $request_data += [
            'active'    => activeStatus(),
            'show_menu' => activeStatus('show_menu'),
            'slug'      => createSlugByModelAndTitle($this->model, $request_data['title'], $content->id),
        ];
        if ($content->id) {
            $entry = $this->model->update($request_data, $content->id);
        } else {
            $entry = $this->model->create($request_data);
        }
        if ($entry) {
            $entry->update([
                'image' => $this->uploadImage($request->file('image'), $entry->title, 'public/contents', $entry->image, Content::MODULE_NAME),
            ]);
            success();

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
