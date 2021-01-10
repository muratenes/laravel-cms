<?php namespace App\Repositories\Concrete\Eloquent;


use App\Models\Region\District;
use App\Models\Region\State;
use App\Repositories\Interfaces\CityTownInterface;

class ElCityTownDal implements CityTownInterface
{

    public function all($filter = null, $columns = array("*"), $relations = null)
    {
        if (!is_null($relations))
            return State::with($relations)->where($filter)->orderBy('title')->get();

        return State::when(!is_null($filter), function ($query) use ($filter) {
            $query->where($filter);
        })->orderBy('title')->get();
    }

    public function allWithPagination($filter = null, $columns = array("*"), $perPageItem = null, $relations = null)
    {
        return [];
    }

    public function getById($id, $columns = array('*'), $relations = null)
    {
        return null;
    }

    public function getByColumn(string $field, $value, $columns = array('*'), $relations = null)
    {
        return null;
    }

    public function create(array $data)
    {
        return null;
    }

    public function update(array $data, $id)
    {
        return null;
    }

    public function delete($id)
    {
        return null;
    }


    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null)
    {
        return null;
    }

    public function getTownsByCityId($cityId)
    {
        return District::where(['state_id' => $cityId, 'active' => 1])->get();
    }

}
