<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface EloquentRepositoryInterface.
 */
interface EloquentRepositoryInterface
{
    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param $value
     * @param string     $column
     * @param null|array $relations
     *
     * @return Model
     */
    public function find($value, string $column = 'id', array $relations = null): ?Model;

    /**
     * @param int   $id
     * @param array $attributes
     *
     * @return Model
     */
    public function update(array $attributes, int $id): Model;

    /**
     * delete record from database by id.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * returns all records.
     *
     * @param null|array $filter
     * @param string[]   $columns
     * @param null       $relations
     * @param string     $orderBy
     *
     * @return mixed
     */
    public function all(array $filter = null, $columns = ['*'], $relations = null, $orderBy = 'id');

    /**
     * returns all filtered data with pagination.
     *
     * @param null|array     $filter
     * @param array|string[] $columns
     * @param null|int       $perPageItem
     * @param null|array     $relations
     *
     * @return LengthAwarePaginator
     */
    public function allWithPagination(array $filter = null, array $columns = ['*'], int $perPageItem = null, array $relations = null): LengthAwarePaginator;
}
