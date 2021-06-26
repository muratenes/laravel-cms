<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\KullaniciAdres;
use App\Repositories\Interfaces\AccountInterface;
use App\User;

class ElAccountDal extends BaseRepository implements AccountInterface
{
    /**
     * AccountRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getUserAddresses($userId, $addressType)
    {
        return KullaniciAdres::with(['country', 'state', 'district', 'neighborhood'])->where(['user_id' => $userId, 'type' => $addressType])->orderByDesc('id')->get();
    }

    /**
     * kullanıcının varsayılan adresini gönderir.
     *
     * @param $userId
     *
     * @return null|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getUserDefaultAddress($userId)
    {
        $user = $this->model->find($userId);
        if (! $user) {
            return null;
        }

        return KullaniciAdres::with(['state', 'district', 'user'])->find($user->default_address_id);
    }

    public function setUserDefaultAddress($userId, $addressId)
    {
        $user = User::with('detail')->find($userId);
        if ($user) {
            $user->update(['default_address_id' => $addressId]);

            return true;
        }

        return false;
    }

    /**
     * @param int   $id     adress id
     * @param array $data   App/Address model data
     * @param int   $userId user id
     *
     * @return mixed
     */
    public function updateOrCreateUserAddress(int $id, array $data, int $userId)
    {
        $data['type'] = ! isset($data['type']) ? KullaniciAdres::TYPE_DELIVERY : $data['type'];
        $user = User::find($userId);
        if (! $id) {
            $address = $user->addresses()->create($data);
        } else {
            $address = KullaniciAdres::find($id);
            $address->update($data);
        }
        $typeColumn = (KullaniciAdres::TYPE_DELIVERY === $data['type']) ? 'default_address_id' : 'default_invoice_address_id';
        $existAddress = KullaniciAdres::find($user->{$typeColumn});
        if (! $user->{$typeColumn} || null === $existAddress) {
            $user->update([
                $typeColumn => $address->id,
            ]);
        }

        return $address;
    }

    /**
     * kullanıcının varsayılan fatura adresini gönderir.
     *
     * @param int $userId User id
     *
     * @return null|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getUserDefaultInvoiceAddress($userId)
    {
        $user = User::find($userId);
        if (! $user) {
            return null;
        }

        return KullaniciAdres::with(['state', 'district', 'user'])->find($user->default_invoice_address_id);
    }

    public function setUserDefaultInvoiceAddress($userId, $addressId)
    {
        $user = User::with('detail')->find($userId);
        if ($user) {
            $user->update(['default_invoice_address_id' => $addressId]);

            return true;
        }

        return false;
    }

    /**
     * kullanıcının gönderilen adreste varsayılan adres var mı yoksa bununla günceller.
     *
     * @param User           $user
     * @param KullaniciAdres $address
     */
    public function checkUserDefaultAddress(User $user, KullaniciAdres $address)
    {
        $typeColumn = KullaniciAdres::TYPE_DELIVERY === $address->type ? 'default_address_id' : 'default_invoice_address_id';
        $existAddress = KullaniciAdres::find($user->{$typeColumn});
        if (! $user->{$typeColumn} || null === $existAddress) {
            $user->update([
                $typeColumn => $address->id,
            ]);
        }
    }
}
