<?php namespace App\Repositories\Interfaces;

interface KullaniciInterface extends BaseRepositoryInterface
{
    public function getAllRolesWithPagination();

    public function getRoleById($id);

    public function createRole($data);

    public function updateRole($id, $data);

    public function deleteRole($id);
}
