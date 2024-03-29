<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OurTeam;
use App\Repositories\Interfaces\OurTeamInterface;
use App\Repositories\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class OurTeamController extends Controller
{
    use ImageUploadTrait;

    protected OurTeamInterface $model;

    public function __construct(OurTeamInterface $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        $query = request('q');
        if ($query) {
            $list = $this->model->allWithPagination([['title', 'like', "%{$query}%"]]);
        } else {
            $list = $this->model->allWithPagination();
        }

        return view('admin.ourTeam.listOurTeam', compact('list'));
    }

    public function newOrEditForm($id = 0)
    {
        $item = new OurTeam();
        if (0 != $id) {
            $item = $this->model->find($id);
        }

        return view('admin.ourTeam.newOrEditOurTeam', compact('item'));
    }

    public function save(Request $request, $id = 0)
    {
        $request_data = $request->only('title', 'position', 'desc');
        $request_data['active'] = activeStatus();
        if (0 != $id) {
            $entry = $this->model->update($request_data, $id);
        } else {
            $entry = $this->model->create($request_data);
        }

        $imagePath = $this->uploadImage($request->file('image'), $entry->title, 'public/our-team', $entry->image, OurTeam::MODULE_NAME);
        $entry->update(['image' => $imagePath]);

        return redirect(route('admin.our_team.edit', $entry->id));
    }

    public function delete($id)
    {
        $this->model->delete($id);

        return redirect(route('admin.our_team'));
    }
}
