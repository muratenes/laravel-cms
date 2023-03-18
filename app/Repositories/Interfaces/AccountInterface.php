<?php

namespace App\Repositories\Interfaces;

use App\Models\UserAddress;
use App\User;

interface AccountInterface
{
    public function getUserAddresses(int $userId, string $addressType);

    /**
     * get user default address.
     */
    public function getUserDefaultAddress(int $userId): ?UserAddress;

    public function setUserDefaultAddress(int $userId, int $addressId): bool;

    public function getUserDefaultInvoiceAddress(int $userId): ?UserAddress;

    public function setUserDefaultInvoiceAddress(int $userId, int $addressId): bool;

    public function updateOrCreateUserAddress(int $id, array $data, int $userId): UserAddress;

    /**
     * check user has default address in type,if not exists update.
     *
     * @param User        $user
     * @param UserAddress $address
     */
    public function checkUserDefaultAddress(User $user, UserAddress $address): bool;
}
