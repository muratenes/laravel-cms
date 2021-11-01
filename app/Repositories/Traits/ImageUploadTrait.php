<?php

namespace App\Repositories\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

trait ImageUploadTrait
{
    /**
     * return file full path.
     *
     * @param null|Illuminate\Http\UploadedFile $image      requestden gelen  dosya
     * @param string                            $imageTitle fotoğraf başlığı
     * @param string                            $folderPath storage altına foto kaydedielecek dizin ex: public/categories/
     * @param $oldImagePath - eğer rsim dosyası boşsa eskisini dönderir
     * @param null|string $moduleName config dosyasında belirtilen modul adı
     *
     * @return string
     */
    public function uploadImage($image, string $imageTitle, string $folderPath, $oldImagePath, $moduleName = null)
    {
        if (! $image) {
            return $oldImagePath;
        }
        $this->validate(request(), [
            'image' => 'mimes:jpg,png,jpeg,gif|max:' . config('admin.max_upload_size'),
        ]);
        $imageQuality = config('admin.image_quality.' . $moduleName) ?? null;
        $extension = $imageQuality ? 'jpg' : $image->extension();
        $imageName = Str::slug($imageTitle) . '-' . Str::random(10) . '.' . $extension;
        if ($imageQuality) {
            $fileFullPath = $folderPath . '/' . $imageName;
            $resizedImage = Image::make($image)->encode('jpg', $imageQuality);
            Storage::put($fileFullPath, (string) $resizedImage);

            return $imageName;
        }

        Storage::putFileAs($folderPath, $image, $imageName);

        return $imageName;
    }

    /**
     * dosya yükleme.
     *
     * @param null|Illuminate\Http\UploadedFile $file
     * @param string                            $fileName          dosya başlığı
     * @param string                            $folderPath        storage altına foto kaydedielecek dizin ex: public/categories/
     * @param string                            $allowedExtensions
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return string
     */
    public function uploadFile($file, string $fileName, string $folderPath, $allowedExtensions = 'pdf,png,jpg,jpeg')
    {
        if (! $file) {
            return;
        }

        $this->validate(request(), [
            $fileName => "mimes:{$allowedExtensions}|max:" . config('admin.max_upload_size'),
        ]);
        $fileName = Str::slug($fileName) . '-' . Str::random(25) . '.' . $file->extension();
        Storage::putFileAs($folderPath, $file, $fileName);

        return $fileName;
    }
}
