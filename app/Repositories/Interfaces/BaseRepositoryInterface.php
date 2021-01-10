<?php namespace App\Repositories\Interfaces;


interface BaseRepositoryInterface
{
    public function all($filter = null, $columns = array("*"), $relations = null);

    public function allWithPagination($filter = null, $columns = array("*"), $perPageItem = null, $relations = null);

    public function getById($id, $columns = array('*'), $relations = null);

    // this function returned 1 record by param $field
    public function getByColumn(string $field, $value, $columns = array('*'), $relations = null);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null);
}
