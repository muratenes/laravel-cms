<?php

namespace App\Repositories\Interfaces;

interface UserInterface
{
    public function getAllRolesWithPagination();

    public function getRoleById($id);

    public function createRole($data);

    public function updateRole($id, $data);

    public function deleteRole($id);
}
