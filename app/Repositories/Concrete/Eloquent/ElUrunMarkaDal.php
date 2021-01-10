<?php


namespace App\Repositories\Concrete\Eloquent;

use App\Models\Product\UrunAttribute;
use App\Models\Product\UrunMarka;
use App\Repositories\Concrete\ElBaseRepository;
use App\Repositories\Interfaces\UrunMarkaInterface;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ElUrunMarkaDal implements UrunMarkaInterface
{

    protected $model;

    public function __construct(UrunMarka $model)
    {
        $this->model = app()->makeWith(ElBaseRepository::class, ['model' => $model]);
    }

    public function all($filter = null, $columns = array("*"), $relations = null)
    {
        return $this->model->all($filter, $columns, $relations)->get();
    }

    public function allWithPagination($filter = null, $columns = array("*"), $perPageItem = null, $relations = null)
    {
        return $this->model->allWithPagination($filter, $columns, $perPageItem, $relations);
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
        return $this->model->delete($id);
    }


    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null)
    {
        return $this->model->with($relations, $filter, $paginate, $perPageItem);
    }

    public function uploadBrandMainImage($brand, $image_file)
    {
        if ($image_file->isValid()) {
            $file_name = $brand->id . '-' .  Str::slug($brand->title) . '.jpg';
            $image_resize = Image::make($image_file->getRealPath());
            if (UrunMarka::IMAGE_RESIZE)
                $image_resize->resize(UrunMarka::IMAGE_RESIZE[0], UrunMarka::IMAGE_RESIZE[1]);
            else if (UrunMarka::IMAGE_RESIZE == null)
                $image_resize->resize((getimagesize($image_file)[0] / 2), getimagesize($image_file)[1] / 2);
            $image_resize->save(public_path(config('constants.image_paths.brand_image_folder_path') . $file_name), UrunMarka::IMAGE_QUALITY);
            $brand->update(['image' => $file_name]);
        } else {
            session()->flash('message', $image_file->getErrorMessage());
            session()->flash('message_type', 'danger');
            return back()->withErrors($image_file->getErrorMessage());
        }
    }
}
