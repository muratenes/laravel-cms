<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\DeleteAllLogsJobs;
use App\Models\Log;
use App\Repositories\Interfaces\LogInterface;
use Illuminate\Http\Request;

class LogController extends Controller
{
    protected LogInterface $model;

    public function __construct(LogInterface $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        $filter = request('q');
        $type = request()->get('type', null);
        $list = Log::when($filter, function ($query) use ($filter) {
            return $query->where('code', 'like', "%{$filter}%")->orWhere('user_id', 'like', "{$filter}")
                ->orWhere('message', 'like', "%{$filter}%")
                ->orWhere('url', 'like', "%{$filter}%")
            ;
        })->when($type, function ($query) use ($type) {
            $query->where('type', $type);
        })->orderByDesc('id')->simplePaginate();
        $logTypes = Log::listTypesWithId();

        return view('admin.log.list_logs', compact('list', 'logTypes'));
    }

    public function show($id)
    {
        $log = Log::findOrFail($id);

        return view('admin.log.show_log', compact('log'));
    }

    public function json(Log $log)
    {
        return response()->json(json_decode($log->exception));
    }

    public function delete($id)
    {
        $this->model->delete($id);

        return redirect(route('admin.logs'));
    }

    public function deleteAll()
    {
//        $this->dispatch(new DeleteAllLogsJobs());
        Log::truncate();

        return redirect(route('admin.logs'))->with('message', 'Bütün log kayıtları silindi');
    }
}
