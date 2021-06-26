<?php

namespace App\Repositories\Interfaces;

interface LogInterface
{
    /**
     * get user logs by id.
     *
     * @param $userId
     *
     * @return mixed
     */
    public function getLogsByUserId($userId);
}
