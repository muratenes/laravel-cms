<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Campaign;
use App\Repositories\Concrete\ElBaseRepository;
use App\Repositories\Interfaces\CampaignInterface;
use Illuminate\Support\Facades\Cache;

class ElCampaignDal implements CampaignInterface
{
    protected $model;

    public function __construct(Campaign $model)
    {
        $this->model = app()->makeWith(ElBaseRepository::class, ['model' => $model]);
    }

    public function all($filter = null, $columns = ['*'], $relations = null)
    {
        return $this->model->all($filter, $columns, $relations)->get();
    }

    public function allWithPagination($filter = null, $columns = ['*'], $perPageItem = null, $relations = null)
    {
        return $this->model->allWithPagination($filter, $columns, $perPageItem);
    }

    public function getById($id, $columns = ['*'], $relations = null)
    {
        return $this->model->getById($id, $columns, $relations);
    }

    public function getByColumn(string $field, $value, $columns = ['*'], $relations = null)
    {
        return $this->model->getByColumn($field, $value, $columns, $relations);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $this->model->update($data, $id);

        return $this->getById($id, null, ['campaignProducts', 'campaignCategories']);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }

    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null)
    {
        return $this->model->with($relations, $filter, $paginate, $perPageItem);
    }

    public function getCampaignDetail($slug, $order = null, $selectedSubAttributeList = null, $category = null, $brandIdList = null)
    {
    }

    public function getLatestActiveCampaigns(int $qty)
    {
        $cache = Cache::get("cacheLatestActiveCampaigns{$qty}");
        if (null === $cache) {
            $cache = Cache::remember("cacheLatestActiveCampaigns{$qty}", 24 * 60, function () {
                return Campaign::select('title', 'slug', 'image')->whereActive(1)->get();
            });
        }

        return $cache;
    }
}
