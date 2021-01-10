<?php

namespace App\Http\Controllers\Admin;

use App\Models\Referance;
use App\Repositories\Interfaces\ReferenceInterface;
use App\Http\Controllers\Controller;
use App\Repositories\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function GuzzleHttp\Psr7\str;

class ReferansController extends Controller
{
    use ImageUploadTrait;

    private ReferenceInterface $_referenceService;

    public function __construct(ReferenceInterface $referenceService)
    {
        $this->_referenceService = $referenceService;
    }

    public function list()
    {
        $query = request('q');
        if ($query) {
            $list = $this->_referenceService->allWithPagination([['title', 'like', "%$query%"]]);
        } else {
            $list = $this->_referenceService->allWithPagination();
        }
        return view('admin.references.listReferences', compact('list'));
    }

    public function newOrEditForm($id = 0)
    {
        $item = new Referance();
        if ($id != 0) {
            $item = $this->_referenceService->getById($id);
        }
        return view('admin.references.newOrEditReference', compact('item'));
    }

    public function save(Request $request,$id = 0)
    {
        $request_data = $request->only('title', 'desc', 'link');
        $request_data['slug'] =  Str::slug($request->get('title'));
        $request_data['slug'] =  createSlugByModelAndTitle($this->_referenceService,$request->title,$id);
        $request_data['active'] = request()->has('active') ? 1 : 0;
        if ($id != 0) {
            $entry = $this->_referenceService->update($request_data, $id);
        } else {
            $entry = $this->_referenceService->create($request_data);
        }
        if ($entry){
            $this->uploadImage($request->file('image'),$entry->title,'public/referanslar',$entry->image,Referance::MODULE_NAME);
            return redirect(route('admin.reference.edit', $entry->id));
        }

        return back()->withInput();
    }

    public function delete($id)
    {
        $this->_referenceService->delete($id);
        return redirect(route('admin.reference'));
    }
}
