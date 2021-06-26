<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referance;
use App\Repositories\Interfaces\ReferenceInterface;
use App\Repositories\Traits\ImageUploadTrait;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReferansController extends Controller
{
    use ImageUploadTrait;

    private ReferenceInterface $referenceService;

    public function __construct(ReferenceInterface $referenceService)
    {
        $this->referenceService = $referenceService;
    }

    public function list()
    {
        $query = request('q');
        if ($query) {
            $list = $this->referenceService->allWithPagination([['title', 'like', "%{$query}%"]]);
        } else {
            $list = $this->referenceService->allWithPagination();
        }

        return view('admin.references.listReferences', compact('list'));
    }

    public function newOrEditForm($id = 0)
    {
        $item = new Referance();
        if (0 !== $id) {
            $item = $this->referenceService->find($id);
        }

        return view('admin.references.newOrEditReference', compact('item'));
    }

    public function save(Request $request, $id = 0)
    {
        $request_data = $request->only('title', 'desc', 'link');
        $request_data['slug'] = Str::slug($request->get('title'));
        $request_data['slug'] = createSlugByModelAndTitle($this->referenceService, $request->title, $id);
        $request_data['active'] = request()->has('active') ? 1 : 0;
        if (0 !== $id) {
            $entry = $this->referenceService->update($request_data, $id);
        } else {
            $entry = $this->referenceService->create($request_data);
        }
        if ($entry) {
            $entry->update([
                'image' => $this->uploadImage($request->file('image'), $entry->title, 'public/references', $entry->image, Referance::MODULE_NAME),
            ]);

            success();

            return redirect(route('admin.reference.edit', $entry->id));
        }

        return back()->withInput();
    }

    public function delete($id)
    {
        $this->referenceService->delete($id);
        success();

        return redirect(route('admin.reference'));
    }
}
