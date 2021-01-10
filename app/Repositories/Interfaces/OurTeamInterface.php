<?php namespace App\Repositories\Interfaces;

interface OurTeamInterface extends BaseRepositoryInterface
{
    public function uploadImage($entry, $image_file);
}
