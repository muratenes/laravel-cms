<?php namespace App\Repositories\Interfaces;

interface BlogInterface extends BaseRepositoryInterface
{
    public function uploadImage($entry, $image_file);
}
