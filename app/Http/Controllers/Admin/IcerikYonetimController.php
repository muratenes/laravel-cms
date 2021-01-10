<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContentManagementRequest;
use App\Models\Content;
use App\Repositories\Interfaces\IcerikYonetimInterface;
use App\Repositories\Traits\ImageUploadTrait;

class IcerikYonetimController extends AdminController
{

    use ImageUploadTrait;

    protected IcerikYonetimInterface $model;

    public function __construct(IcerikYonetimInterface $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        $query = request('q');
        if ($query) {
            $list = $this->model->allWithPagination([['title', 'like', "%$query%"]], null, null, 'parentContent');
        } else {
            $list = $this->model->allWithPagination(null, null, null, 'parentContent');
        }
        return view('admin.content.listContents', compact('list'));
    }

    public function newOrEditForm($id = 0)
    {
        $item = new Content();
        $contents = $this->model->all();
        if ($id != 0) {
            $item = $this->model->getById($id);
        }
        $languages = $this->languages();
        return view('admin.content.newOrEditContent', compact('item', 'languages', 'contents'));
    }

    public function save(ContentManagementRequest $request, $id = 0)
    {
        $request_data = $request->only('title', 'spot', 'desc', 'lang', 'parent');
        $request_data['active'] = activeStatus();
        $request_data['slug'] = createSlugByModelAndTitle($this->model,$request_data['title'],$id);
        if ($id != 0) {
            $entry = $this->model->update($request_data, $id);
        } else {
            $entry = $this->model->create($request_data);
        }
        if ($entry){
            $this->uploadImage($request->file('image'),$entry->title,'public/icerik-yonetim',Content::MODULE_NAME);
            return redirect(route('admin.content.edit', $entry->id));
        }

        return back()->withInput();
    }

    public function delete($id)
    {
        $this->model->delete($id);
        \Cache::forget('contents');
        return redirect(route('admin.content'));
    }
}
