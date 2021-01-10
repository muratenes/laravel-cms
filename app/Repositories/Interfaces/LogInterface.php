<?php namespace App\Repositories\Interfaces;

interface LogInterface extends BaseRepositoryInterface
{
    public function getLogsByUserId($userId);
}
