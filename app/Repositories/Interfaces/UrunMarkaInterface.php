<?php namespace App\Repositories\Interfaces;


interface UrunMarkaInterface extends BaseRepositoryInterface
{
    public function uploadBrandMainImage($brand, $image_file);
}
