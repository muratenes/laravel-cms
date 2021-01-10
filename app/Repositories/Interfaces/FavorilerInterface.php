<?php namespace App\Repositories\Interfaces;

interface FavorilerInterface extends BaseRepositoryInterface
{
    public function getAnomimUserFavoritesList($productIdList);
}
