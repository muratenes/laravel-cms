<?php

namespace App\Repositories\Concrete;

use App\Models\Log;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ElBaseRepository implements BaseRepositoryInterface
{
    // model property on class instances
    public $model;

//     Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all($filter = null, $columns = ['*'], $relations = null)
    {
        if (null === $columns) {
            $columns = ['*'];
        }
        if ($filter) {
            return $this->model->when(null !== $relations, function ($query) use ($relations) {
                return $query->with($relations);
            })->select($columns)->where($filter)->orderByDesc('id');
        }

        return $this->model->when(null !== $filter, function ($query) use ($filter) {
            return $query->where($filter);
        })->when(null !== $relations, function ($query) use ($relations) {
            return $query->with($relations);
        })->orderByDesc('id');
    }

    // Get all instances of model with pagination
    public function allWithPagination($filter = null, $columns = ['*'], $perPageItem = null, $relations = null)
    {
        if (null === $columns) {
            $columns = ['*'];
        }

        return $this->model->when(null !== $relations, function ($query) use ($relations) {
            return $query->with($relations);
        })->select($columns)->when(null !== $filter, function ($query) use ($filter) {
            return $query->where($filter);
        })->orderByDesc('id')->paginate((null === $perPageItem ? $this->model->getPerPage() : $perPageItem), $columns);
    }

    // Get object by Id
    public function getById($id, $columns = ['*'], $relations = null)
    {
        if (null === $columns) {
            $columns = ['*'];
        }
        if (null !== $relations) {
            return $this->model->select($columns)->with($relations)->find($id, $columns);
        }

        return $this->model->find($id, $columns);
    }

    // create a new record in the database
    public function create(array $data)
    {
        try {
            $record = $this->model->create($data);
            session()->flash('message', config('constants.messages.success_message'));

            return $record;
        } catch (\Exception $exception) {
            session()->flash('message_type', 'danger');
            session()->flash('message', $exception->getMessage());
            Log::addLog(($this->getModelTableName() . '' . ' eklerken bir sorun oluştu ' . $exception->getMessage()), $exception, Log::TYPE_CREATE_OBJECT);
        }
    }

    // update record in the database
    public function update(array $data, $id)
    {
        try {
            $record = $this->model->findOrFail($id);
            $record->update($data);
            session()->flash('message', config('constants.messages.success_message'));

            return $record;
        } catch (\Exception $exception) {
            session()->flash('message_type', 'danger');
            session()->flash('message', [$exception->getMessage() . '']);
            Log::addLog(($this->getModelTableName() . '' . ' güncellerken bir sorun oluştu ' . $exception->getMessage()), $exception, Log::TYPE_CREATE_OBJECT);
        }
    }

    // remove record from the database
    public function delete($id)
    {
        try {
            $record = $this->model->findOrFail($id);
            $record->delete();
            session()->flash('message', config('constants.messages.success_message'));

            return $record;
        } catch (\Exception $exception) {
            session()->flash('message_type', 'danger');
            session()->flash('message', $exception->getMessage());
            Log::addLog(($this->getModelTableName() . '' . ' silinirken bir sorun oluştu ' . $exception->getMessage()), $exception, Log::TYPE_CREATE_OBJECT);
        }
    }

    public function getByColumn(string $field, $value, $columns = ['*'], $relations = null)
    {
        if (null === $columns) {
            $columns = ['*'];
        }

        return $this->model->select($columns)->where($field, $value)->when(null !== $relations, function ($query) use ($relations) {
            return $query->with($relations);
        })->firstOrFail();
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Get the associated model table name
    public function getModelTableName()
    {
        return $this->model->getTable();
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    // Eager load database relationships
    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null)
    {
        return $this->model->with($relations)->when($filter, function ($query) use ($filter) {
            return $query->where($filter);
        })->orderByDesc('id')->when(null !== $paginate, function ($query) use ($paginate, $perPageItem) {
            if (false === $paginate) {
                return $query->get();
            }

            return $query->paginate(null !== $perPageItem ? $perPageItem : (null === $this->model->getPerPage() ? config('constants.default_per_page_item') : $this->model->getPerPage()));
        });
    }
}
