<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all($filter = null, $columns = ['*'], $relations = null);

    public function allWithPagination($filter = null, $columns = ['*'], $perPageItem = null, $relations = null);

    public function getById($id, $columns = ['*'], $relations = null);

    // this function returned 1 record by param $field
    public function getByColumn(string $field, $value, $columns = ['*'], $relations = null);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null);
}
