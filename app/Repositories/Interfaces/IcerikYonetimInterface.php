<?php namespace App\Repositories\Interfaces;

interface IcerikYonetimInterface extends BaseRepositoryInterface
{
    public function uploadMainImage($content, $image_file);
}
