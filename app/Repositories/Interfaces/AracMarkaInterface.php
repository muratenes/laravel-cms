<?php namespace App\Repositories\Interfaces;

interface AracMarkaInterface extends BaseRepositoryInterface
{
    public function getModelsByMarkaId($id, $isActive = null);
}
