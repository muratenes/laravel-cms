<?php

namespace App\Http\Controllers;

use App\Models\Region\Neighborhood;
use App\Repositories\Interfaces\CityTownInterface;

class CityTownController extends Controller
{
    protected CityTownInterface $model;

    public function __construct(CityTownInterface $model)
    {
        $this->model = $model;
    }

    public function getTownsByCityId($cityId)
    {
        return $this->model->getTownsByCityId($cityId);
    }

    public function getNeighByDistrictId($districtId)
    {
        return Neighborhood::where(['district_id' => $districtId])->orderBy('title')->get();
    }
}
