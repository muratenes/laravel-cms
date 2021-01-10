<?php namespace App\Repositories\Concrete\Eloquent;

use App\Jobs\DeleteAllLogsJobs;
use App\Models\Banner;
use App\Models\Log;
use App\Repositories\Concrete\ElBaseRepository;
use App\Repositories\Interfaces\BannerInterface;
use App\Repositories\Interfaces\LogInterface;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ElBannerDal implements BannerInterface
{

    protected $model;

    public function __construct(Banner $model)
    {
        $this->model = app()->makeWith(ElBaseRepository::class, ['model' => $model]);
    }

    public function all($filter = null, $columns = array("*"), $relations = null)
    {
        return $this->model->all($filter, $columns, $relations)->get();
    }

    public function allWithPagination($filter = null, $columns = array("*"), $perPageItem = null, $relations = null)
    {
        return $this->model->allWithPagination($filter, $columns, $perPageItem);
    }

    public function getById($id, $columns = array('*'), $relations = null)
    {
        return $this->model->getById($id, $columns, $relations);
    }

    public function getByColumn(string $field, $value, $columns = array('*'), $relations = null)
    {
        return $this->model->getByColumn($field, $value, $columns, $relations);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->update($data, $id);
    }

    public function delete($id)
    {
        $item = $this->getById($id);
        if ($item->image) {
            $image_path = getcwd() . config('constants.image_paths.banner_image_folder_path') . $item->image;
            if (file_exists($image_path)) {
                \File::delete($image_path);
            }
        }
        return $this->model->delete($id);
    }

    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null)
    {
        return $this->model->with($relations, $filter, $paginate, $perPageItem);
    }

}
