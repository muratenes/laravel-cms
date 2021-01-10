<?php namespace App\Repositories\Concrete\Eloquent;

use App\Jobs\DeleteAllLogsJobs;
use App\Models\Log;
use App\Repositories\Concrete\ElBaseRepository;
use App\Repositories\Interfaces\LogInterface;

class ElLogDal implements LogInterface
{

    protected $model;

    public function __construct(Log $model)
    {
        $this->model = app()->makeWith(ElBaseRepository::class, ['model' => $model]);
    }

    public function all($filter = null, $columns = array("*"), $relations = null)
    {
        return $this->model->all($filter, $columns, $relations)->get();
    }

    public function allWithPagination($filter = null, $columns = array("*"), $perPageItem = null, $relations = null)
    {
        return $this->model->all()->when($filter, function ($query) use ($filter) {
            return $query->where('code', 'like', "%$filter%")->orWhere('level', 'like', "%$filter%")->orWhere('user_id', 'like', "$filter")
                ->orWhere('message', 'like', "%$filter%")
                ->orWhere('url', 'like', "%$filter%");
        })->simplePaginate();
    }

    public function getById($id, $columns = array('*'), $relations = null)
    {
        return $this->model->getById($id, $columns, $relations);
    }

    public function getByColumn(string $field, $value, $columns = array('*'), $relations = null)
    {
        return $this->model->getByColumn($field, $value, $columns, $relations);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->update($data, $id);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }


    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null)
    {
        return $this->model->with($relations, $filter, $paginate, $perPageItem);
    }

    public function getLogsByUserId($userId)
    {
        return Log::where('user_id', $userId)->orderByDesc('id')->get();
    }
}
