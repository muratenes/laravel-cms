<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param $value
     * @param string     $column
     * @param null|array $relations
     *
     * @return Model
     */
    public function find($value, string $column = 'id', array $relations = null): ?Model
    {
        return $this->model->where($column, $value)->when($relations, function ($q, $relations) {
            $q->with($relations);
        })->first();
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param int   $id
     * @param array $attributes
     *
     * @return Model
     */
    public function update(array $attributes, int $id): Model
    {
        $item = $this->model->find($id);
        $item->update($attributes);

        return $item;
    }

    /**
     * delete record from database by id.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $item = $this->model->find($id);

        return (bool) $item->delete();
    }

    public function all(array $filter = null, $columns = ['*'], $relations = null, $orderBy = 'id')
    {
        return $this->model->when($relations, function ($query) use ($relations) {
            return $query->with($relations);
        })
            ->select($columns)
            ->when($filter, function ($query) use ($filter) {
                return $query->where($filter);
            })->orderByDesc($orderBy)->get();
    }

    public function allWithPagination(array $filter = null, array $columns = ['*'], int $perPageItem = null, array $relations = null): LengthAwarePaginator
    {
        return $this->model->when($relations, function ($query) use ($relations) {
            return $query->with($relations);
        })->select($columns)->when($filter, function ($query) use ($filter) {
            return $query->where($filter);
        })->latest('id')->paginate($perPageItem);
    }
}
