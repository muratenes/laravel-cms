<?php namespace App\Repositories\Concrete\Eloquent;

use App\Models\Gallery;
use App\Models\GalleryImages;
use App\Repositories\Concrete\ElBaseRepository;
use App\Repositories\Interfaces\FotoGalleryInterface;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ElFotoGalleryDal implements FotoGalleryInterface
{
    use ResponseTrait;
    private $model;

    public function __construct(Gallery $model)
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

    public function uploadMainImage($reference, $image_file)
    {
        try {
            if ($image_file->isValid()) {
                $file_name = $reference->id . '-' .  Str::slug($reference->title) . '.jpg';
                $image_resize = Image::make($image_file->getRealPath());
                if (Gallery::IMAGE_RESIZE)
                    $image_resize->resize(Gallery::IMAGE_RESIZE[0], Gallery::IMAGE_RESIZE[1]);
                else if (Gallery::IMAGE_RESIZE == null)
                    $image_resize->resize((getimagesize($image_file)[0] / 2), getimagesize($image_file)[1] / 2);
                $image_resize->save(public_path(config('constants.image_paths.gallery_main_image_folder_path') . $file_name), Gallery::IMAGE_QUALITY);
                $reference->update(['image' => $file_name]);
            } else {
                session()->flash('message', $image_file->getErrorMessage());
                session()->flash('message_type', 'danger');
                return back()->withErrors($image_file->getErrorMessage());
            }
        } catch (\Exception $exception) {
            session()->flash('message', $exception->getMessage());
            session()->flash('message_type', 'danger');
        }

    }

    public function uploadImageGallery($galleryId, $image_files, $entry)
    {
        foreach (request()->file("imageGallery") as $index => $file) {
            try {
                if ($index < 10) {
                    if ($file->isValid()) {
                        $file_name = $galleryId . '-' .  Str::slug($entry->title) .  Str::random(6) . '.jpg';
                        $image_resize = Image::make($file->getRealPath());
                        if (GalleryImages::IMAGE_RESIZE)
                            $image_resize->resize(GalleryImages::IMAGE_RESIZE[0], GalleryImages::IMAGE_RESIZE[1]);
                        else if (GalleryImages::IMAGE_RESIZE == null)
                            $image_resize->resize((getimagesize($file)[0] / 2), getimagesize($file)[1] / 2);
                        $image_resize->save(public_path(config('constants.image_paths.gallery_images_folder_path') . $file_name), GalleryImages::IMAGE_QUALITY);
                        GalleryImages::create(['gallery_id' => $galleryId, 'image' => $file_name]);
                    }
                } else {
                    session()->flash('message', 'ürüne ait en fazla 10 adet resim yükleyebilirsiniz');
                    session()->flash('message_type', 'danger');
                    break;
                }
            } catch (\Exception $exception) {
                session()->flash('message', $exception->getMessage());
                session()->flash('message_type', 'danger');
            }

        }
        return true;
    }

    public function deleteGalleryImage($id)
    {
        $galleryImage = GalleryImages::find($id);
        if (is_null($galleryImage))
            return $this->response(false, 'resim bulunamadı');
        $image_path = getcwd() . '/' . config('constants.image_paths.gallery_images_folder_path') . $galleryImage->image;
        if (file_exists($image_path)) {
            \File::delete($image_path);
            $galleryImage->delete();
            return $this->response(true, 'işlem başarılı');
        } else {
            return $this->response(false, 'dosya bulunamadı');
        }
    }
}
