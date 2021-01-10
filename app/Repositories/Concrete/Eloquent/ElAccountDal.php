<?php namespace App\Repositories\Concrete\Eloquent;

use App\Models\KullaniciAdres;
use App\Repositories\Concrete\ElBaseRepository;
use App\Repositories\Interfaces\AccountInterface;
use App\User;

class ElAccountDal implements AccountInterface
{

    protected $model;

    public function __construct(User $model)
    {
        $this->model = app()->makeWith(ElBaseRepository::class, ['model' => $model]);
    }

    public function all($filter = null, $columns = array("*"), $relations = null)
    {
        return $this->model->all($filter, $columns, $relations)->get();
    }

    public function allWithPagination($filter = null, $columns = array("*"), $perPageItem = null, $relations = null)
    {
        return $this->model->allWithPagination($filter, $columns, $perPageItem);
    }

    public function getById($id, $columns = array('*'), $relations = null)
    {
        return $this->model->getById($id, $columns, $relations);
    }

    public function getByColumn(string $field, $value, $columns = array('*'), $relations = null)
    {
        return $this->model->getByColumn($field, $value, $columns, $relations);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->update($data, $id);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }


    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null)
    {
        return $this->model->with($relations, $filter, $paginate, $perPageItem);
    }

    public function getUserAddresses($userId, $addressType)
    {
        return KullaniciAdres::with(['country', 'state', 'district', 'neighborhood'])->where(['user_id' => $userId, 'type' => $addressType])->orderByDesc('id')->get();
    }

    public function getAddressById($addressId)
    {
        return KullaniciAdres::find($addressId);
    }

    /**
     * kullanıcının varsayılan adresini gönderir
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getUserDefaultAddress($userId)
    {
        $user = User::find($userId);
        if (!$user) return null;
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
     * @param int $id adress id
     * @param array $data App/Address model data
     * @param int $userId user id
     * @return mixed
     */
    public function updateOrCreateUserAddress(int $id, array $data, int $userId)
    {
        $data['type'] = !isset($data['type']) ? KullaniciAdres::TYPE_DELIVERY : $data['type'];
        $user = User::find($userId);
        if (!$id) {
            $address = $user->addresses()->create($data);
        } else {
            $address = KullaniciAdres::find($id);
            $address->update($data);
        }
        $typeColumn = ($data['type'] == KullaniciAdres::TYPE_DELIVERY) ? "default_address_id" : "default_invoice_address_id";
        $existAddress = KullaniciAdres::find($user->{$typeColumn});
        if (!$user->{$typeColumn} || is_null($existAddress)) {
            $user->update([
                $typeColumn => $address->id
            ]);
        }
        return $address;
    }

    /**
     * kullanıcının varsayılan fatura adresini gönderir
     * @param int $userId User id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getUserDefaultInvoiceAddress($userId)
    {
        $user = User::find($userId);
        if (!$user) return null;
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
     * kullanıcının gönderilen adreste varsayılan adres var mı yoksa bununla günceller
     * @param User $user
     * @param KullaniciAdres $address
     */
    public function checkUserDefaultAddress(User $user, KullaniciAdres $address)
    {
        $typeColumn = $address->type == KullaniciAdres::TYPE_DELIVERY ? "default_address_id" : "default_invoice_address_id";
        $existAddress = KullaniciAdres::find($user->{$typeColumn});
        if (!$user->{$typeColumn} || is_null($existAddress)) {
            $user->update([
                $typeColumn => $address->id
            ]);
        }
    }
}
