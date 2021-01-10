<?php namespace App\Repositories\Interfaces;

interface FotoGalleryInterface extends BaseRepositoryInterface
{
    public function uploadMainImage($reference, $image_file);

    public function uploadImageGallery($galleryId, $image_files, $entry);

    public function deleteGalleryImage($id);
}
