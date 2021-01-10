<?php

namespace App\Repositories\Traits;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

trait ImageUploadTrait
{
    /**
     * return file full path.
     *
     * @param Illuminate\Http\UploadedFile|null $image requestden gelen  dosya
     * @param string $imageTitle fotoğraf başlığı
     * @param string $folderPath storage altına foto kaydedielecek dizin ex: public/categories/
     *
     * @param $oldImagePath - eğer rsim dosyası boşsa eskisini dönderir
     * @param null|string $moduleName config dosyasında belirtilen modul adı
     * @return string
     */
    public function uploadImage($image, string $imageTitle, string $folderPath, $oldImagePath, $moduleName = null)
    {
        if (!$image) return $oldImagePath;
        $this->validate(request(), [
            'image' => 'image|mimes:jpg,png,jpeg,gif|max:' . config('admin.max_upload_size')
        ]);
        $imageQuality = config('admin.image_quality.'.$moduleName) ?? null;
        $extension = $imageQuality ? 'jpg' : $image->extension();
        $imageName = Str::slug($imageTitle) . '-' . Str::random(10) . '.' . $extension;
        if ($imageQuality) {
            $fileFullPath = $folderPath . '/' . $imageName;
            $resizedImage = Image::make($image)->encode('jpg', $imageQuality);
            Storage::put($fileFullPath, (string)$resizedImage);
            return $imageName;
        }

        Storage::putFileAs($folderPath, $image, $imageName);
        return $imageName;
    }
}
