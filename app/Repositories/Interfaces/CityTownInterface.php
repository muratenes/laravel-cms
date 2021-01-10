<?php namespace App\Repositories\Interfaces;

interface CityTownInterface extends BaseRepositoryInterface
{
    public function getTownsByCityId($cityId);
}
