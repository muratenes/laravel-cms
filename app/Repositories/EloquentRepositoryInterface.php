<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

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
}
