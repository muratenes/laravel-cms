<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface EloquentRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model;

    /**
     * @param int $id
     * @param array $attributes
     *
     * @return Model
     */
    public function update(array $attributes,int $id): Model;

    /**
     * delete record from database by id
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * returns all records
     *
     * @param array|null $filter
     * @param string[] $columns
     * @param null $relations
     * @param string $orderBy
     * @return mixed
     */
    public function all(array $filter = null, $columns = array('*'), $relations = null, $orderBy = 'id');

    /**
     * returns all filtered data with pagination
     *
     * @param array|null $filter
     * @param array|string[] $columns
     * @param int|null $perPageItem
     * @param array|null $relations
     * @return LengthAwarePaginator
     */
    public function allWithPagination(array $filter = null, array $columns = ["*"], int $perPageItem = null, array $relations = null) : LengthAwarePaginator;
}
