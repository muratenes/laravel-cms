<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

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
     * @param $id
     * @return Model
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
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
     * @param int $id
     * @param array $attributes
     *
     * @return Model
     */
    public function update(array $attributes,int $id): Model
    {
        $item = $this->model->find($id);
        $item->update($attributes);
        return $item;
    }

    /**
     * delete record from database by id
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $item = $this->model->find($id);
        return (bool) $item->delete();
    }


}
