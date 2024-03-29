<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\UserAddress;
use App\Repositories\Interfaces\AccountInterface;
use App\User;

class ElAccountDal extends BaseRepository implements AccountInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getUserAddresses(int $userId, string $addressType)
    {
        return UserAddress::with(['country', 'state', 'district', 'neighborhood'])
            ->where(['user_id' => $userId, 'type' => $addressType])
            ->orderByDesc('id')
            ->get()
        ;
    }

    public function getUserDefaultAddress(int $userId): ?UserAddress
    {
        $user = $this->model->find($userId);
        if (! $user) {
            return null;
        }

        return UserAddress::with(['state', 'district', 'user'])->find($user->default_address_id);
    }

    public function setUserDefaultAddress(int $userId, int $addressId): bool
    {
        $user = User::find($userId);
        if ($user) {
            $user->update(['default_address_id' => $addressId]);

            return true;
        }

        return false;
    }

    /**
     * @param int   $id     address id
     * @param array $data   App/Address model data
     * @param int   $userId user id
     *
     * @return mixed
     */
    public function updateOrCreateUserAddress(int $id, array $data, int $userId): UserAddress
    {
        $data['type'] = $data['type'] ?? UserAddress::TYPE_DELIVERY;
        $user = $this->model->find($userId);
        if (! $id) {
            $address = $user->addresses()->create($data);
        } else {
            $address = UserAddress::find($id);
            $address->update($data);
        }
        $typeColumn = (UserAddress::TYPE_DELIVERY === $data['type']) ? 'default_address_id' : 'default_invoice_address_id';
        $existAddress = UserAddress::find($user->{$typeColumn});

        if (! $user->{$typeColumn} || null === $existAddress) {
            $user->update([
                $typeColumn => $address->id,
            ]);
        }

        return $address;
    }

    public function getUserDefaultInvoiceAddress(int $userId): ?UserAddress
    {
        $user = User::find($userId);
        if (! $user) {
            return null;
        }

        return UserAddress::with(['state', 'district', 'user'])->find($user->default_invoice_address_id);
    }

    public function setUserDefaultInvoiceAddress(int $userId, int $addressId): bool
    {
        $user = User::with('detail')->find($userId);
        if (! $user) {
            return false;
        }

        $user->update(['default_invoice_address_id' => $addressId]);

        return true;
    }

    public function checkUserDefaultAddress(User $user, UserAddress $address): bool
    {
        $typeColumn = UserAddress::TYPE_DELIVERY === $address->type ? 'default_address_id' : 'default_invoice_address_id';
        $existAddress = UserAddress::find($user->{$typeColumn});

        if (! $user->{$typeColumn} || null === $existAddress) {
            $user->update([
                $typeColumn => $address->id,
            ]);

            return true;
        }

        return false;
    }
}
