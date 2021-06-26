<?php

namespace App\Repositories\Interfaces;

use App\Models\KullaniciAdres;
use App\User;

interface AccountInterface
{
    public function getUserAddresses($userId, $addressType);

    /** kullanıcı varsayılan adresi getirir.
     * @param int $userId
     *
     * @return mixed
     */
    public function getUserDefaultAddress($userId);

    public function setUserDefaultAddress($userId, $addressId);

    /**
     * @param int $userId User id
     *
     * @return mixed
     */
    public function getUserDefaultInvoiceAddress($userId);

    public function setUserDefaultInvoiceAddress($userId, $addressId);

    public function updateOrCreateUserAddress(int $id, array $data, int $userId);

    public function checkUserDefaultAddress(User $user, KullaniciAdres $address);
}
