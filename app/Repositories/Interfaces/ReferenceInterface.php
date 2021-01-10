<?php namespace App\Repositories\Interfaces;

interface ReferenceInterface extends BaseRepositoryInterface
{
    public function uploadMainImage($reference, $image_file);
}
